<?php
namespace Leone\Promos\Controller\Pages;

use Leone\Promos\Utils;
use Exception;
use Leone\Promos\Model\Entity\Newsletter as News;

/**
 * Classe responsável por controlar todas as páginas da Newsletter
 */
class Newsletter extends Page{
  
  /**
   * Método responsável por processar a requisição Ajax e retorna uma resposta 
   * @return array
   */
  public static function processAjax(): array{
    $data = json_decode(file_get_contents('php://input'), true);
    $result['success'] = false;
    $nome = $data['nome']??'';
    $email = $data['email']??'';
    $g_response = $data['g-recaptcha-response']??'';
    try {
      if (empty($nome) || empty($email) || empty($g_response)) {
        throw new Exception('Algum campo foi passado vazio!');
      }
      
      if (mb_strlen($nome,'UTF-8')>20 || mb_strlen($nome,'UTF-8')<3 || strlen($g_response)<20 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email)>100){
        throw new Exception('Algum campo está inválido!');
      }
      
      $recaptcha = new Utils\Recaptcha($g_response);
      
      if ($recaptcha->isOrNotV3()) {
        throw new Exception('Talvez você seja um robô!');
      }
      
      $newsletter = new News($email, $nome);
      
      if ($newsletter->verifyByEmail()) {
        throw new Exception('E-mail já cadastrado, se ainda não o confirmou verifique sua caixa de SPAM/Lixo Eletrônico!');
      }
      
      $key = Utils\Hash::generateHash();
      
      $html = Utils\View::render('emails/confirmar',[
      'key' => $key,
      'nome' => $nome,
      'ano' => date('Y')
      ]);
      
      $send_email = Utils\Mail::sendOne($email, $nome, 'Confirme seu e-mail!', $html);
      
      if ($send_email !== true) {
        throw new Exception('Tivemos um problema para enviar o e-mail de confirmação verifique o e-mail e tente novamente mais tarde.');
      }
      
      $newsletter->key = $key;
      $newsletter->insert();
      
      $result['success'] = true;
      $result['message'] = 'O e-mail <code>'.$email.'</code> foi cadastrado com sucesso, você vai receber um e-mail pra confirmar seu cadastro, clique no link para confirmar. Verifique sua caixa de SPAM/Lixo Eletrônico.';
    }catch (Exception $e){
      $result['message'] = $e->getMessage();
    }finally{
      return $result;
    }
  }
  
  /*
   * Faz a validação da chave passada se tudo estiver ok, realiza a ação e passa para o método responsável processar a resposta
   * @param integer 1|0 $action
   * @return string
   */
  public static function validateKey(int $action): string{
    $key = $_GET['key']??'';
    if (strlen($key)!=32 || !ctype_xdigit($key)){
      throw new Exception('', 401);
    }
    
    $newsletter = new News('', '', $key);
    if (!$newsletter->verifyByKey()) {
      throw new Exception('', 403);
    }
    
    if ($action===1) {
      if (!$newsletter->verifyNoConfirmByKey()) {
        throw new Exception('', 404);
      }
      $newsletter->confirm();
      $title = 'E-mail confirmado!';
      $content = '<p class="bolder container">Obrigado! Seu e-mail foi confirmado com sucesso!</p>';
    }else{
      $newsletter->delete();
      $title = 'E-mail descadastrado!';
      $content = '<p class="bolder container">Vamos sentir sua falta :(, mas respeitamos sua decisão, nunca é um adeus e sim um até logo!</p>';
    }
    return Page::getPage($title, '<h2 class="container" id="title">'.$title.'</h2>'.$content);
  }
  
}