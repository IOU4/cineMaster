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
    $this->title = $params['title'];
    $this->description = $params['description'];;
    $this->comments_count = $params['comments_count'];;
    $params = [$this->title, $this->description, $this->comments_count, $this->id];
    if($this->id)
      $this->model->update($params);
  }

  function get_id() {
    return "id => ".$this->id."\xa";
  }

  function get_all() {
    return " id => ".$this->id."\xa title => ".$this->title."\xa description => ".$this->description."\xa comment_count => ".$this->comments_count."\xa";
  }

  function fetch_all() {
    $posts = $this->model->fetch_all();
    $result = [];
    foreach($posts as $post)
      $result[] = new Post($post['title'], $post['description'], $post['comments_count'], $post['id']); 
    return $result;
  }
}

$post = new Post('lala land', "I really don't know what really this movie about, but seems from the cover photo that it's had something to do with romance", 5);
echo ($post->get_all());
$post->update(["title"=>'new title', "description"=>"new description it's 100% not like the original", "comments_count"=>4]);
echo ($post->get_all());
