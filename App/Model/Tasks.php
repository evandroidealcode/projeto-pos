<?php

namespace App\Model;

use App\Library\Database;

class Tasks extends Database {

  protected $table = "tbl_tarefas";

  public function insert($values){
    $fields = array_keys($values);
    $binds  = array_pad([],count($fields),'?');
    $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

    $this->execute($query,array_values($values));
    return $this->connection->lastInsertId();
  }

  public function select($where = null, $order = null, $limit = null, $fields = '*'){
    $where = strlen($where) ? 'WHERE '.$where : '';
    $order = strlen($order) ? 'ORDER BY '.$order : '';
    $limit = strlen($limit) ? 'LIMIT '.$limit : '';
    $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

    return $this->execute($query);
  }

  public function update($where,$values){
    $fields = array_keys($values);
    $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

    $this->execute($query,array_values($values));
    return true;
  }

  public function delete($where){
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    $this->execute($query);
    return true;
  }
}