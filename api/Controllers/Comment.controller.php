<?php
include_once './Models/Comment.model.php';
class Comment {

  private $id;
  private $post_id;
  private $author_id;
  private $content;
  private $created_at;
  private $model;

  function __construct($author_id, $post_id, $content, $created_at = null, $id = null) {

    $this->id = $id;
    $this->author_id = $author_id;
    $this->post_id = $post_id;
    $this->content = $content;
    $this->created_at = $created_at;
    $this->model = new CommentModel();
    
  }

  function add() {
    $params = array($this->post_id, $this->author_id, $this->content);
    $this->id = $this->model->add($params);
  }

  function update($params) {
    $this->content = isset($params['content']) ? $params['content'] : $this->content;
    $params = [$this->post_id, $this->author_id, $this->content, $this->id];
    $this->model->update($params);
  }

  function delete() {
    $params = array($this->id);
    $this->model->delete($params);
  }


  function get_id() {
    return "id => ".$this->id."\xa";
  }

  function get_all() {
    return ["id"=>$this->id," post_id"=>$this->post_id, "author_id"=>$this->author_id, "content"=>$this->content, 'created_at'=>$this->created_at];
  }

  static function fetch_all() {
    $postModel = new CommentModel();
    $result = $postModel->fetch_all();
    return $result;
  }
  
  static function fetch_by_id($id) {
    $commentModel = new CommentModel();
    $comment = $commentModel->fetch_by_id($id); 
    return new Comment($comment['post_id'], $comment['author_id'], $comment['content'], $comment['created_at'], $id);
  }
  
  static function fetch_by_post($post_id) {
    $commentModel = new CommentModel();
    $comments = $commentModel->fetch_by_post($post_id);
    return $comments;
  }
}

