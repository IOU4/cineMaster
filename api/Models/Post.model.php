<?php
require_once './Models/Database.php';

class PostModel extends Model {

  function add($params) {
    $query = 'insert into posts (title, description, likes_count, author_id) values(?, ?, ?, ?)';
    $this->execStatement($query, $params);
    return $this->execStatement('select last_insert_id() as id')->get_result()->fetch_assoc()['id'];
  }
  
  function update($params) {
    $query = 'update posts set title = ?, description = ?, likes_count = ? where id = ?';
    $this->execStatement($query, $params);
  }
  
  function delete($params) {
    $query = 'delete from posts where id = ?';
    $this->execStatement($query, $params);
  }
  
  function get_id() {
    return $this->id;
  }
  
  function fetch_all() {
    $query = 'select * from posts'; 
    $stmnt = $this->execStatement($query);
    $result = $stmnt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  function fetch_by_id($id) {
    $query = 'select * from posts where id = ?';
    $stmnt = $this->execStatement($query, [$id]);
    return $stmnt->get_result()->fetch_assoc();
  }

  function fetch_by_user($author_id) {
    $query = 'select * from posts where author_id = ?';
    $stmnt = $this->execStatement($query, [$author_id]);
    return $stmnt->get_result()->fetch_all();
  }

}
