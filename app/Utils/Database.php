<?php
namespace Promos\Utils;

use \PDO;
use \PDOException;
use \Exception;
use \Promos\Controller\Notify\Send;

/**
 * Classe responsável por fazer a conexão com o banco de dados
 */
class Database{
  
  const HOST = '{host-do-banco-de-dados}';
  const NAME = '{nome-do-banco-de-dados}';
  const USER = '{usuario-do-banco-de-dados}';
  const PASS = '{senha-do-banco-de-dados}';
  private $table;
  private $connection;
  
  /**
   * Define a tabela e a instância da conexão
   */
  public function __construct($table=null){
    $this->table = $table;
    $this->setConnection();
  }
  
  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(){
    try{
      $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      $content = file_exists('app/error_db.txt')?file_get_contents('app/error_db.txt'):'';
      $content .= $e->getMessage();
      file_put_contents('app/error_db.txt', $content);
      $data = [
        'title' => 'Erro no banco de dados!',
        'msg' => $e->getMessage(),
        'link' => '/'
        ];
      $notify = new Send;
      $notify->oneNotification('', $data);
      throw new Exception('<h1>Erro interno no servidor</h1>', 500);
    }
  }
  
  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param  string $query
   * @param  array  $params
   * @return PDOStatement
   */
  public function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      echo $query;
      die;
      $content = file_exists('app/error_db.txt')?file_get_contents('app/error_db.txt'):'';
      $content .= $e->getMessage();
      file_put_contents('app/error_db.txt', $content);
      $data = [
        'title' => 'Erro no banco de dados!',
        'msg' => $e->getMessage(),
        'link' => '/'
        ];
      $notify = new Send;
      $notify->oneNotification('', $data);
      throw new Exception('<h1>Erro interno no servidor</h1>', 500);
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param  array $values [ field => value ]
   * @return integer ID inserido
   */
  public function insert($values){
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
    $this->execute($query,array_values($values));
    return $this->connection;
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param  array|string $where
   * @param  string $order
   * @param  string $limit
   * @param  string $fields
   * @return PDOStatement
   */
  public function select($where = '', $limit = null, $fields = '*', $order = null){
    if (is_array($where)) {
      $text = 'WHERE '.$where['col'].' = ?';
      $params[0] = $where['val'];
    }elseif (!empty($where)){
      $text = 'WHERE '.$where;
      $params = [];
     }else{
      $text = '';
      $params = [];
    }
    $order = strlen($order)?'ORDER BY '.$order:'';
    $limit = strlen($limit)?'LIMIT '.$limit : '';
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$text.' '.$limit.' '.$order;
    return $this->execute($query, $params);
  }

  /**
   * Método responsável por executar atualizações no banco de dados
   * @param string $where
   * @param array|string $values [ field => value ]
   * @return boolean
   */
  public function update($values, $where = ''){
    $where = strlen($where)?' WHERE '.$where:'';
    if (is_array($values)) {
      $fields = array_keys($values);
      $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=?'.$where;
      $this->execute($query,array_values($values));
    }else{
      $query = 'UPDATE '.$this->table.' SET '.$values.$where;
      $this->execute($query);
    }
    return true;
  }

  /**
   * Método responsável por excluir dados do banco
   * @param  string|array $where
   * @return boolean
   */
  public function delete($where){
    if (is_array($where)) {
      $text = 'WHERE '.$where['col'].' = ?';
      $params[0] = $where['val'];
    }else{
      $text = 'WHERE '.$where;
      $params = [];
     }
    $query = 'DELETE FROM '.$this->table.' '.$text;
    $this->execute($query, $params);
    return true;
  }
  
  /**
   * Método responsável por alterar a tabela padrão para querys no dados do banco
   * @param string $table
   */
  public function setTable($table){
    if ($table !== $this->table){
      $this->table = $table;
    }
  }

}