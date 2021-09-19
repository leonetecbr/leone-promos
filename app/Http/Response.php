<?php
namespace Leone\Promos\Http;

/**
 * Classe responsável por processar a resposta para o cliente
 */
class Response{
  
  private $httpCode = 200;
  private $headers = [];
  private $contentType = 'text/html';
  private $content;
  
  /**
   * Preenche as variáveis com os dados da resposta
   * @param integer $httpCode
   * @param array|string $content
   * @param string $contentType
   */
  public function __construct(int $httpCode, $content= '', string $contentType = 'text/html'){
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }
  
  /**
   * Preenche o contentType na variável e no cabeçalho da resposta
   * @param string $contentType
   */
  public function setContentType(string $contentType){
    $this->contentType = $contentType;
    $this->addHeader('Content-Type', $contentType);
  }
  
  /**
   * Adiciona mais um cabeçalho ao cabeçalho da resposta
   * @param string $key
   * @param string $value
   */
  public function addHeader(string $key, string $value){
    $this->headers[$key] = $value;
  }
  
  /**
   * Envia o cabeçalho da resposta para o navegador
   */
  public function sendHeaders(){
    http_response_code($this->httpCode);
    
    foreach ($this->headers as $key => $value){
      header($key.': '.$value);
    }
  }
  
  /**
   * Envia a resposta para o navegador
  */
  public function sendResponse(){
    $this->sendHeaders();
    
    switch ($this->contentType) {
      case 'application/json':
        echo json_encode($this->content, JSON_UNESCAPED_UNICODE);
        exit;
      
      default:
        echo $this->content;
        exit;
    }
  }
}