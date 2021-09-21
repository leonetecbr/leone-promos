<?php
namespace Leone\Promos\Utils;

use PDO;
use PDOException;
use Exception;
use Leone\Promos\Controller\Notify\Send;

/**
 * Classe responsável por fazer a conexão com o banco de dados
 */
class Database{
  
  private $table;
  private $connection;
  
  /**
   * Define a tabela e a instância da conexão
   * @param string $table
   */
  public function __construct(string $table=''){
    $this->table = $table;
    $this->setConnection();
  }
  
  /**
   * Método responsável por criar uma conexão com o banco de dados
   */
  private function setConnection(): void{
    try{
      $this->connection = new PDO('mysql:host='.$_ENV['HOST_DB'].';dbname='.$_ENV['BANK_DB'],$_ENV['USER_DB'],$_ENV['PASS_DB']);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      $content = "\n\n".$e->getMessage();
      file_put_contents('resources/logs/error_db.txt', $content, FILE_APPEND);
      $data = [
        'title' => 'Erro no banco de dados!',
        'msg' => $e->getMessage(),
        'link' => '/'
        ];
      $notify = new Send;
      $notify->oneNotification('', $data);
      throw new Exception('', 500);
    }
  }
  
  /**
   * Método responsável por executar queries dentro do banco de dados
   * @param string $query
   * @param array  $params
   * @return PDOStatement
   */
  public function execute(string $query, array $params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      $content = "\n\n".$e->getMessage();
      file_put_contents('resources/logs/error_db.txt', $content, FILE_APPEND);
      $data = [
        'title' => 'Erro no banco de dados!',
        'msg' => $e->getMessage(),
        'link' => '/'
        ];
      $notify = new Send;
      $notify->oneNotification('', $data);
      throw new Exception('', 500);
    }
  }

  /**
   * Método responsável por inserir dados no banco
   * @param array $values [ field => value ]
   * @return PDOStatement
   */
  public function insert(array $values){
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
    $this->execute($query, array_values($values));
    return $this->connection;
  }

  /**
   * Método responsável por executar uma consulta no banco
   * @param array|string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   * @return PDOStatement
   */
  public function select($where = '', string $limit = '', string $fields = '*', string $order = ''){
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
  public function update($values, string $where = ''): bool{
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
   * @param string|array $where
   * @return boolean
   */
  public function delete($where): bool{
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
  public function setTable(string $table): void{
    if ($table !== $this->table){
      $this->table = $table;
    }
  }

}