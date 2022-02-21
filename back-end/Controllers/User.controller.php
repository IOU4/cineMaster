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

  function delete() {
    $params = array($this->id);
    $this->model->delete($params);
  }

  function update($params) {
    $this->title = isset($params['title']) ? $params['title'] : $this->title;
    $this->description = isset($params['description']) ? $params['description'] : $this->description;
    $this->likes_count = isset($params['likes_count']) ? $params['likes_count'] : $this->likes_count;
    $this->cover = isset($params['cover']) ? $params['cover'] : $this->cover;
    $params = [$this->title, $this->description, $this->likes_count, $this->id];
    $this->model->update($params);
  }

  function get_id() {
    return "id => ".$this->id."\xa";
  }

  function get_all() {
    return ["id"=>$this->id," title"=>$this->title, "description"=>$this->description, "likes_count"=>$this->likes_count, 'author_id'=>$this->author_id, 'created_at'=>$this->created_at];
  }

  static function fetch_all() {
    $postModel = new PostModel();
    $result = $postModel->fetch_all();
    // $posts = [];
    // foreach($result as $post)
    //   $posts[] = new Post($post['title'], $post['description'], $post['likes_count'], $post['id']); 
    return $result;
  }
  
  static function fetch_by_id($id) {
    $postModel = new PostModel();
    $post = $postModel->fetch_by_id($id); 
    return new Post($post['author_id'], $post['title'], $post['description'], $post['likes_count'], $post['created_at'], $id);
  }

}

