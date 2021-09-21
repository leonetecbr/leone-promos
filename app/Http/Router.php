<?php
namespace Leone\Promos\Http;

use Closure;
use ReflectionFunction;
use Leone\Promos\Controller\Pages\ErrorsHTTP;

/**
 * Classes responsável por identificar as rotas acessadas
 */
class Router{
  
  private $url = '';
  private $prefix = '';
  private $routes = [];
  private $request = '';
  
  /**
   * Passa a instância do request para a variável
   */
  public function __construct(){
    $this->request = new Request;
  }
  
  /**
   * Verifica se a rota acessada é igual a definida, caso seja um array é inserido na variável $routes
   * @var string $method
   * @var string $route
   * @var array $params
   */
  private function addRoute(string $method, string $route, array $params = []): void{
    foreach ($params as $key=>$value){
      if ($value instanceof Closure) {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }
    
    $params['variables'] = [];
    
    $patternVar = '/{(.*?)}/';
    
    if (preg_match_all($patternVar, $route, $matches)) {
      
      for ($i = 0; $i < count($matches[1]); $i++) {
        $match = $matches[1][$i];
        $variaveis = explode(':', $match, 2);
        if ($variaveis[0] == 'int' && count($variaveis)==2) {
          $replace = '([0-9]+)';
        }else {
          $variaveis[1] = $variaveis[0];
          $variaveis[0] = 'string';
          $replace = '(\w+)';
        }
        
        $matches[1][$i] = $variaveis[1];
        
        $route = preg_replace('/{'.$match.'}/', $replace, $route);
      }
      
      $params['variables'] = $matches[1];
    }
    
    $route = rtrim(strtolower($route), '/');
    
    $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
    
    $this->routes[$patternRoute][$method] = $params;
  }
  
  /**
   * Pega o URI
   * @return string
   */
  public function getUri(): string{
    $uri = rtrim(strtolower($this->request->getUri()), '/');
    return $uri;
  }
  
  /**
   * Verifica se o método e a rota está correta, caso o método não esteja, um HTTP 405 é retornado, caso a rota não esteja run() emite o HTTP 404
   * @return array
   */
  private function getRoute(): array{
    $uri = $this->getUri();
    $httpMethod = $this->request->getHttpMethod();
    
    foreach ($this->routes as $patternRoute=>$methods){
      if (preg_match($patternRoute, $uri, $matches)) {
        if (isset($methods[$httpMethod])) {
          unset($matches[0]);
          $keys = $methods[$httpMethod]['variables'];
          $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
          return $methods[$httpMethod];
        }
        throw new Exception('', 405);
      }
    }
    return [];
  }
  
  /**
   * Processa Requisições GET
   * @var string $route
   * @var array $params (instância de response)
   */
  public function get(string $route, array $params = []): void{
    $this->addRoute('GET', $route, $params);
  }
  
  /**
   * Processa Requisições POST
   * @var string $route
   * @var array $params (instância de response)
   */
  public function post(string $route, array $params = []): void{
    $this->addRoute('POST', $route, $params);
  }
  
  /**
   * Verifica se há um controlador definido para a rota, se positivo retorna um array, caso contrário retorna HTTP 404
   * @return mixed
   */
  public function run(){
    try {
      $route = $this->getRoute();
      if (empty($route['controller'])) {
        throw new Exception('<h1>Página não encontrada</h1>', 404);
      }
      $args = [];
      
      $reflex = new ReflectionFunction($route['controller']);
      
      foreach ($reflex->getParameters() as $parameter){
        $name = $parameter->getName();
        $args[$name] = $route['variables'][$name]??'';
      }
      
      return call_user_func_array($route['controller'], $args);
      
    } catch (Exception $e) {
      $code = $e->getCode();
      return new Response($code, ErrorsHTTP::getCode($code, $e->getMessage()));
    }
  }
}
