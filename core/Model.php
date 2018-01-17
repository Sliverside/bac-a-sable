<?php

class Model{

  static $connections = array();
  public $conf = 'default';
  public $table = false;
  public $db;
  public $primaryKey = 'ID';

  function __construct(){
    if($this->table == false){
      $this->table = strtolower(get_class($this)).'s';
    }
    $conf = Conf::$databases[$this->conf];
    if(isset(Model::$connections[$this->conf])) {
      $this->db = Model::$connections[$this->conf];
      return true;
    }
    try{
      $pdo = new PDO(
        'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
        $conf['login'],
        $conf['password'],
        array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
      Model::$connections[$this->conf] = $pdo;
      $this->db = $pdo;
    }catch(PDOException $e){
      if(Conf::$debug == 1){
        die($e->getMessage());
      }
    }
  }

  public function find($req) {
    $sql = 'SELECT ';

    if(isset($req['fields'])) {
      if(is_array($req['fields'])){
        $sql.= implode(', ', $req['fields']);
      }else{
        $sql.= $req['fields'];
      }
    }else {
      $sql.= '*';
    }

    $sql .= ' FROM '.$this->table.' as '.get_class($this).' ';

    if(isset($req['conditions'])) {
      $sql .= ' WHERE ';
      if(!is_array($req['conditions'])){
        $sql.= $req['conditions'];
      }else{
        $cond = array();
        foreach ($req['conditions'] as $k => $v) {
          if(is_numeric($v)){
            $cond[] = "$k=$v";
          }else{
            $cond[] = "$k='$v'";
          }
        }
        $sql .= implode(' AND ', $cond);
      }
    }

    if(isset($req['limit'])) {
      $sql .= ' LIMIT '.$req['limit'];
    }
    $pre = $this->db->prepare($sql);
    $pre->execute();
    return $pre->fetchALL(PDO::FETCH_OBJ);
  }

  public function findFirst($req){
    return current($this->find($req));
  }

  public function findCount($conditions) {
    $res = $this->findFirst(array(
      'fields' => 'COUNT('.$this->primaryKey.') as count',
      'conditions' => $conditions
    ));
    return $res->count;
  }

  public function delete($primaryKey) {
    $sql = "DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = '$primaryKey'";
    $this->db->query($sql);
  }

}

?>
