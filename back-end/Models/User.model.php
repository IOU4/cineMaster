<?php
require_once './Models/Database.php';

class UserModel extends Model {

  function add($params) {
    $query = 'insert into users (username, email, password) values(?, ?, ?)';
    $this->execStatement($query, $params);
    return $this->execStatement('select last_insert_id() as id')->get_result()->fetch_assoc()['id'];
  }
  
  function update($params) {
    $query = 'update users set username = ?, post_id = ?, content = ? where id = ?';
    $this->execStatement($query, $params);
  }
  
  function delete($params) {
    $query = 'delete from users where id = ?';
    $this->execStatement($query, $params);
  }
  
  function get_id() {
    return $this->id;
  }
  
  function fetch_all() {
    $query = 'select * from users'; 
    $stmnt = $this->execStatement($query);
    $result = $stmnt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  function fetch_by_id($id) {
    $query = 'select * from users where id = ?';
    $stmnt = $this->execStatement($query, [$id]);
    return $stmnt->get_result()->fetch_assoc();
  }

}
