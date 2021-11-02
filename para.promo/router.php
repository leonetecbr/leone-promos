<?php
function redirect(string $url = 'https://ofertas.leone.tec.br')
{
  http_response_code(303);
  header("Location: $url");
  die;
}

function processPage(int $cat_id, int $page, int $oferta_id): string
{
  switch ($cat_id) {
    case 77:
      $path = 'categorias/smartphones';
      break;

    case 2:
      $path = 'categorias/informatica';
      break;

    case 1:
      $path = 'categorias/eletronicos';
      break;

    case 116:
      $path = 'categorias/eletrodomesticos';
      break;

    case 22:
      $path = 'categorias/pc';
      break;

    case 194:
      $path = 'categorias/bonecas';
      break;

    case 2852:
      $path = 'categorias/tv';
      break;

    case 138:
      $path = 'categorias/fogao';
      break;

    case 3673:
      $path = 'categorias/geladeira';
      break;

    case 3671:
      $path = 'categorias/lavaroupas';
      break;

    case 7690:
      $path = 'categorias/roupasm';
      break;

    case 7691:
      $path = 'categorias/roupasf';
      break;

    case 2735:
      $path = 'categorias/talheres';
      break;

    case 2712:
      $path = 'categorias/camas';
      break;

    case 2701:
      $path = 'categorias/casaedeco';
      break;

    case 2801:
      $path = 'categorias/armario';
      break;

    case 2916:
      $path = 'categorias/mesas';
      break;

    case 2930:
      $path = 'categorias/luz';
      break;

    case 5632:
      $path = 'lojas/americanas';
      break;

    case 5727:
      $path = 'lojas/girafa';
      break;

    case 5766:
      $path = 'lojas/submarino';
      break;

    case 5644:
      $path = 'lojas/shoptime';
      break;

    case 7863:
      $path = 'lojas/brandili';
      break;

    case 6358:
      $path = 'lojas/usaflex';
      break;

    case 6078:
      $path = 'lojas/electrolux';
      break;

    case 7460:
      $path = 'lojas/itatiaia';
      break;

    case 5936:
      $path = 'lojas/brastemp';
      break;

    case 6117:
      $path = 'lojas/positivo';
      break;

    case 6373:
      $path = 'lojas/etna';
      break;

    case 6104:
      $path = 'lojas/repassa';
      break;

    case 0:
      $path = '';
      break;

    default:
      return '';
  }

  $path .= ($page === 1) ? '' : '/' . $page;
  $path .= '#' . $cat_id . '_' . $page . '_' . $oferta_id;

  return $path;
}

/**
 * Classes responsável por identificar as rotas acessadas
 */
class Router
{

  private $routes = [];

  /**
   * Verifica se a rota acessada é igual a definida, caso seja um array é inserido na variável $routes
   * @var string $method
   * @var string $route
   * @var array $params
   */
  private function addRoute(string $method, string $route, array $params = []): void
  {
    foreach ($params as $key => $value) {
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
        if ($variaveis[0] == 'int' && count($variaveis) == 2) {
          $replace = '([0-9]+)';
        } else {
          $variaveis[1] = $variaveis[0];
          $variaveis[0] = 'string';
          $replace = '(\w+)';
        }

        $matches[1][$i] = $variaveis[1];

        $route = preg_replace('/{' . $match . '}/', $replace, $route);
      }

      $params['variables'] = $matches[1];
    }

    $route = rtrim(strtolower($route), '/');

    $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

    $this->routes[$patternRoute][$method] = $params;
  }

  /**
   * Pega o URI
   * @return string
   */
  public function getUri(): string
  {
    $urn = parse_url($_SERVER['REQUEST_URI']);
    $uri = rtrim(strtolower($urn['path']), '/');
    return $uri;
  }

  /**
   * Verifica se o método e a rota está correta, caso o método não esteja, um HTTP 405 é retornado, caso a rota não esteja run() emite o HTTP 404
   * @return array
   */
  private function getRoute(): array
  {
    $uri = $this->getUri();
    $httpMethod = $_SERVER['REQUEST_METHOD'];

    foreach ($this->routes as $patternRoute => $methods) {
      if (preg_match($patternRoute, $uri, $matches)) {
        if (isset($methods[$httpMethod])) {
          unset($matches[0]);
          $keys = $methods[$httpMethod]['variables'];
          $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
          return $methods[$httpMethod];
        }
        throw new Exception;
      }
    }
    return [];
  }

  /**
   * Processa Requisições GET
   * @var string $route
   * @var array $params (instância de response)
   */
  public function get(string $route, array $params = []): void
  {
    $this->addRoute('GET', $route, $params);
  }

  /**
   * Processa Requisições POST
   * @var string $route
   * @var array $params (instância de response)
   */
  public function post(string $route, array $params = []): void
  {
    $this->addRoute('POST', $route, $params);
  }

  /**
   * Verifica se há um controlador definido para a rota, se positivo retorna um array, caso contrário retorna HTTP 404
   * @return mixed
   */
  public function run()
  {
    try {
      $route = $this->getRoute();
      if (empty($route['controller'])) {
        throw new Exception;
      }
      $args = [];

      $reflex = new ReflectionFunction($route['controller']);

      foreach ($reflex->getParameters() as $parameter) {
        $name = $parameter->getName();
        $args[$name] = $route['variables'][$name] ?? '';
      }

      return call_user_func_array($route['controller'], $args);
    } catch (Exception $e) {
      redirect();
    }
  }
}
