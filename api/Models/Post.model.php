<?php
require_once './Models/Database.php';

class PostModel extends Model {

  function add($params) {
    $query = 'insert into posts (title, description, likes_count, author_id, cover) values(?, ?, ?, ?, ?)';
    $this->execStatement($query, $params);
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
    $query = 'select posts.id, posts.title, posts.description, posts.created_at, users.username from posts join users on posts.author_id = users.id order by id desc'; 
    $stmnt = $this->execStatement($query);
    $result = $stmnt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  function fetch_by_id($id) {
    $query = 'select posts.id, posts.title, posts.description, posts.created_at, posts.cover, users.username from posts join users on posts.author_id = users.id where posts.id = ?';
    $stmnt = $this->execStatement($query, [$id]);
    return $stmnt->get_result()->fetch_assoc();
  }

  function fetch_by_user($author) {
    $query = 'select posts.id, posts.title, posts.description, posts.created_at, posts.cover, users.username from posts join users on posts.author_id = users.id where users.username = ? order by id desc';
    $stmnt = $this->execStatement($query, [$author]);
    return $stmnt->get_result()->fetch_all(MYSQLI_ASSOC);
  }

}
