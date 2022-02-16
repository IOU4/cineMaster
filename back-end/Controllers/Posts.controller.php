<?php
include_once './Models/Posts.model.php';
class Post {
  private $id;
  private $title;
  private $description;
  private $comments_count;
  private $model;

  function __construct($title = '', $description = '', $comments_count = 0, $id = null) {
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
    $this->comments_count = $comments_count;
    $this->model = new PostModel();
    
  }
  function add() {
    echo "adding post ... \xa";
    $params = [$this->title, $this->description, $this->comments_count];
    $this->id = $this->model->add($params);
  }

  function delete() {
    if(!$this->id) 
      throw new Exception("post not in table");
      $params = [$this->id];
      $this->model->delete($params);
  }

  function update($params) {
    $this->title = isset($params['title']) ? $params['title'] : $this->title;
    $this->description = isset($params['description']) ? $params['description'] : $this->description;
    $this->comments_count = isset($params['comments_count']) ? $params['comments_count'] : $this->comments_count;
    $params = [$this->title, $this->description, $this->comments_count, $this->id];
    if($this->id)
      $this->model->update($params);
  }

  function get_id() {
    return "id => ".$this->id."\xa";
  }

  function get_all() {
    return " id => ".$this->id."\xa title => ".$this->title."\xa description => ".$this->description."\xa comments_count => ".$this->comments_count."\xa";
  }

  static function fetch_all() {
    $postModel = new PostModel();
    $result = $postModel->fetch_all();
    // $posts = [];
    // foreach($result as $post)
    //   $posts[] = new Post($post['title'], $post['description'], $post['comments_count'], $post['id']); 
    return $result;
  }
  
  static function fetch_one($id) {
    $postModel = new PostModel();
    $post = $postModel->fetch_one($id); 
    return new Post($post['title'], $post['description'], $post['comments_count'], $id);
  }
}
