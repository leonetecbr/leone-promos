<?php
namespace Promos\Utils;

use \PHPMailer\PHPMailer\PHPMailer;

/**
 * Classe para enviar e-mails
 */
class Mail{
  
  /**
   * Método para enviar um e-mail
   * @params string $to $name $subject $html
   * @param array $auth
   * @return true/string
   */
  public static function sendOne($to, $name, $subject, $html, $auth = ['email'=> $_ENV['SMTP_USER'], 'pass' => $_ENV['SMTP_PASS']]){
    $mail = new PHPMailer();
    $mail->setLanguage('pt_br', __DIR__.'/../../vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php');
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = '{host-do-servidor-SMTP}';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = $auth['email'];
    $mail->Password = $auth['pass'];
    $mail->Port = 587;
    $mail->setFrom($auth['email'], "Leone Promos");
    if (!empty($auth['reply']) and !empty($auth['reply_name'])){
      $mail->addReplyTo($auth['reply'], $auth['reply_name']);
    }
    $mail->addAddress($to, $name);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $html;
    $mail->AltBody = 'Este e-mail não está disponível nesse aplicativo de e-mail.';
    if(!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }
  }
}