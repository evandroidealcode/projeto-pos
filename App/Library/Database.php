<?php

namespace App\Library;

use \PDO;
use \PDOException;

class Database {
  protected $table;
  protected $connection;

  public function __construct(){
    $this->setConnection();
  }

  private function setConnection(){
    try{
      $this->connection = new PDO('mysql:host='.HOST.'; dbname='.DATABASE, USER, PASS);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }

  public function execute($query,$params = []){
    try{
      $statement = $this->connection->prepare($query);
      $statement->execute($params);
      return $statement;
    }catch(PDOException $e){
      die('ERROR: '.$e->getMessage());
    }
  }
}