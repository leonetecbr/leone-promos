<?php
namespace Leone\Promos\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \Leone\Promos\Controller\Pages\ErrorsHTTP;

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
   * @return mixed
   */
  private function addRoute($method, $route, $params = []){
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
      $route = preg_replace($patternVar, '(.*?)', $route);
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
  public function getUri(){
    $uri = rtrim(strtolower($this->request->getUri()), '/');
    return $uri;
  }
  
  /**
   * Verifica se o método e a rota está correta, caso o método não esteja, um HTTP 405 é retornado, caso a rota não esteja run() emite o HTTP 404
   * @return mixed
   */
  private function getRoute(){
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
  }
  
  /**
   * Processa Requisições GET
   * @var string $route
   * @var array $params (instancia de response)
   */
  public function get($route, $params = []){
    return $this->addRoute('GET', $route, $params);
  }
  
  /**
   * Processa Requisições POST
   * @var string $route
   * @var array $params (instancia de response)
   */
  public function post($route, $params = []){
    return $this->addRoute('POST', $route, $params);
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
