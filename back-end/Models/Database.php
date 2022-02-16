<?php
class Model {
  protected $connection;
  const DB_NAME = 'CineMaster';
  const DB_USER = 'root';
  const DB_HOST = 'localhost';
  const DB_PASS = 'emad';
  
  function __construct() {
    $connection = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
    $this->connection = $connection; 
  }
  
  function execStatement($query, $params = []) {
    $stmnt = $this->connection->prepare($query);   
    $stmnt->execute($params); 
    return $stmnt;
  } 
}
