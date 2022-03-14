<?php
include_once './Models/Post.model.php';
include_once './Controllers/Comment.controller.php';
class Post {

  private $id;
  private $title;
  private $description;
  private $likes_count;
  private $cover;
  private $author_id;
  private $created_at;
  private $model;

  function __construct($author_id, $title = '', $description = '', $likes_count = 0, $cover = '', $created_at = null, $id = null) {

    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
    $this->likes_count = $likes_count;
    $this->author_id = $author_id;
    $this->cover = $cover;
    $this->created_at = $created_at;
    $this->model = new PostModel();
    
  }

  function add() {
    if(!empty($_FILES['cover']['name'])) {
      $this->cover = basename($_FILES['cover']['full_path']);
      move_uploaded_file($_FILES['cover']['tmp_name'], '/home/emadou/Work/CineMaster/api/uploaded/'.$this->cover);
    }
    $params = array($this->title, $this->description, $this->likes_count, $this->author_id, $this->cover);
    $this->id = $this->model->add($params);
    echo json_encode(['added'=>true]);
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
    $posts = $postModel->fetch_all();
    $posts = array_map(function($post){
      $comments = Comment::fetch_by_post($post['id']);
      $post['comments'] = $comments; 
      return $post;
    }, $posts);
    return  $posts;
  }
  
  static function fetch_by_id($id) {
    $postModel = new PostModel();
    $post = $postModel->fetch_by_id($id); 
    $comments =  Comment::fetch_by_post($id); 
    $post['comments'] = $comments;
    return $post;
  }

  static function fetch_by_user($author) {
    $postModel = new PostModel(); 
    $posts = $postModel->fetch_by_user($author);
    $posts = array_map(function($post){
      $comments = Comment::fetch_by_post($post['id']);
      $post['comments'] = $comments; 
      return $post;
    }, $posts);
    return $posts;
  }

}
