<?php
namespace Promos\Model\Entity;

use \Promos\Utils\Database;

/**
 * Classe criada para gerenciar a Newsletter
 */
class Newsletter{
  public $email;
  public $nome;
  public $key;
  private $db;
  
  /**
   * Passa os dados para as variáveis da classe
   * @params string $email $nome $key
   */
  public function __construct($email='', $nome='', $key=''){
    $this->email = $email;
    $this->nome = $nome;
    $this->key = $key;
  }
  
  /**
   * Verifica se já existe uma conexão com o banco de dados e tabela da Newsletter, se não cria e a retorna
   * @return PDOStatement
   */
  private function getDB(){
    if (empty($this->db)){
      $this->db = new Database('newsletter');
    }
    return $this->db;
  }
  
  /**
   * Insere os dados no banco de dados e retorna a chave
   * @return string
   */
  public function insert(){
    $dados = [
      'nome' => $this->nome,
      'email' => $this->email,
      'hash' => $this->key
      ];
    $db = $this->getDB();
    $db->insert($dados);
    return $this->key;
  }
  
  
  /**
   * Verifica se o e-mail já está inscrito, retorna true se estiver
   * @return boolean
   */
  public function verifyByEmail(){
    $dados = [
      'col' => 'email',
      'val' => $this->email
      ];
    $db = $this->getDB();
    $dado = $db->select($dados)->fetch();
    return !empty($dado);
  }
  
  /**
   * Verifica se a chave é correspondente a um e-mail inscrito, retorna true se for correspondente
   * @return boolean
   */
  public function verifyByKey(){
    $dados = [
      'col' => 'hash',
      'val' => $this->key
      ];
    $db = $this->getDB();
    $dado = $db->select($dados)->fetch();
    return !empty($dado);
  }
  
  /**
   * Verifica se o e-mail ainda não foi confirmado, retorna true se não estiver
   * @return boolean
   */
  public function verifyNoConfirmByKey(){
    $db = $this->getDB();
    $dado = $db->select('hash = "'.$this->key.'" AND verifed = 0')->fetch();
    return !empty($dado);
  }
  
  /**
   * Deleta o usuário do banco de dados
   */
  public function delete(){
    $db = $this->getDB();
    $dado = $db->delete('hash = "'.$this->key.'"');
  }
  
  /**
   * Faz a confirmação do e-mail
   */
  public function confirm(){
    $db = $this->getDB();
    $dado = $db->update('verifed = 1','hash = "'.$this->key.'"');
  }
}