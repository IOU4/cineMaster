<?php
require_once './Models/Database.php';

class PostModel extends Model {

  function add($params) {
    echo "adding post  in Model ... \xa";
    $query = 'insert into posts (title, description, comments_count) values(?, ?, ?)';
    $this->execStatement($query, $params);
    return $this->execStatement('select last_insert_id() as id')->get_result()->fetch_assoc()['id'];
  }
  
  function update($params) {
    $query = 'update posts set title = ?, description = ?, comments_count = ? where id = ?';
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

  function fetch_one($id) {
    $query = 'select title, description, comments_count from posts where id = ?';
    $stmnt = $this->execStatement($query, [$id]);
    return $stmnt->get_result()->fetch_assoc();
  }
}
