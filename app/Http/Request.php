<?php
namespace Leone\Promos\Http;

/**
 * Classe responsável por tratar as informações da requisição do cliente
 */
class Request{
  private $HttpMethod;
  private $uri;
  private $queryParams = [];
  private $postVars = [];
  private $headers = [];
  
  /**
   * Preenche as variáveis com os dados da requisição
   */
  public function __construct(){
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders();
    $this->HttpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $uri = parse_url($_SERVER['REQUEST_URI']);
    $this->uri = $uri['path'] ?? '';
  }
  
  /**
   * Retorna o método HTTP usado na requisição
   * @return string
   */
  public function getHttpMethod(): string{
    return $this->HttpMethod;
  }
  
  /**
   * Retorna os dados passados por POST
   * @return array
   */
  public function getPostVars(): array{
    return $this->postVars;
  }
  
  /**
   * Retorna o cabeçalho da requisição
   * @return array
   */
  public function getHeaders(): array{
    return $this->headers;
  }
  
  /**
   * Retorna a URI requisitada
   * @return string
   */
  public function getUri(): string{
    return $this->uri;
  }
  
  /**
   * Retorna os dados passados por GET
   * @return array
   */
  public function getQueryParams(): array{
    return $this->queryParams;
  }
}