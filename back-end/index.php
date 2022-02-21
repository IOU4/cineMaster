<?php 
require_once './Controllers/Global.controller.php';

$app = new Controller();

$app->get('/', function() {
  header('content-type: application/json');
  echo json_encode(['message'=>'welcome to CineMaster API']);
});

// posts --------------
$app->get('/posts', function() {
  require_once './Controllers/Post.controller.php'; 
  header('content-type: application/json');
  echo json_encode(Post::fetch_all());
});

$app->get('/post', function($query) {
  if(empty($query['id'])) 
    throw new Exception('please provide a valid id');
  require_once './Controllers/Post.controller.php'; 
  header('content-type: application/json');
  echo json_encode(Post::fetch_by_id($query['id'])->get_all());
});

$app->delete('/post', function($data){
  if(!isset($data['id']))
    throw new Exception('please provide a valid id');
  require_once './Controllers/Post.controller.php'; 
  $post = Post::fetch_by_id($data['id']);
  $post->delete();
  header('content-type: application/json');
  echo json_encode(['deleted'=>true]);
});

$app->put('/post', function($data) {
  if(empty($data['id']))
    throw new Exception('please provide a valid id');

  $new_data = [];

  if(isset($data['title'])) $new_data['title'] = $data['title'];
  if(isset($data['description'])) $new_data['description'] = $data['description'];
  if(isset($data['likes_count'])) $new_data['likes_count'] = $data['likes_count'];

  require_once './Controllers/Post.controller.php'; 
  $post = Post::fetch_by_id($data['id']);
  $post->update($new_data);
  header('content-type: application/json');
  echo json_encode(['updated'=>true]);
});

$app->post('/add/post', function($data) {
  if(!isset($data['author_id'], $data['title'], $data['description'], $data['likes_count'])) 
    throw new Exception('please provide a valid id');

  require_once './Controllers/Post.controller.php'; 
  $post = new Post($data['author_id'], $data['title'], $data['description'], $data['likes_count']);
  $post->add();
  header('content-type: application/json');
  echo json_encode(['added'=>true]);
});

// comments ------------------------------
$app->get('/comments', function() {
  require_once './Controllers/Comment.controller.php'; 
  header('content-type: application/json');
  echo json_encode(Comment::fetch_all());
});

$app->get('/comments/post', function($query){
  if(empty($query['post_id']))
    throw new Exception('please proivde a post id'); 
  require_once './Controllers/Comment.controller.php';
  header('content-type: application/json');
  echo json_encode(Comment::fetch_by_post($query['post_id']));
});

$app->post('/add/comment', function($data){
  if(!isset($data['post_id'], $data['author_id'], $data['content']))
    throw new Exception('please provide post_id, author_id and a content');
  require_once './Controllers/Comment.controller.php';
  $comment = new Comment($data['author_id'], $data['post_id'], $data['content']);
  $comment->add();
  header('content-type: application/json');
  echo json_encode(['added'=>true]);
});

$app->delete('/comment', function($data){
  if(empty($data['id']))
    throw new Exception('please proivde an id');
  require_once './Controllers/Comment.controller.php';
  $comment = Comment::fetch_by_id($data['id']);
  $comment->delete();
  header('content-type: application/json');
  echo json_encode(['deleted'=>true]);
});

$app->put('/comment', function($data){
  if(empty($data['id']))
    throw new Exception('please provide a valid id');

  $new_data = [];
  if(isset($data['content'])) $new_data['content'] = $data['content'];

  require_once './Controllers/Comment.controller.php';
  $comment = Comment::fetch_by_id($data['id']);
  $comment->update($new_data);
  header('content-type: application/json');
  echo json_encode(['updated'=>true]);
});

// useres ---------------------------
$app->get('/users', function(){
  require_once './Controllers/User.controller.php';
  header('content-type: application/json');
  echo json_encode(User::fetch_all());
});

$app->get('/user', function($query){
  if(empty($query['id']))
    throw new Exception('please proivde an id');
  require_once './Controllers/User.controller.php';
  echo json_encode(User::fetch_by_id($query['id'])->get_all());
});

$app->post('/add/user', function($data){
  if(!isset($data['username'], $data['email'], $data['password']))
    throw new Exception('please provide post_id, author_id and a content');
  require_once './Controllers/User.controller.php';
  $user = new User($data['username'], $data['email'], $data['password']);
  $user->add();
  header('content-type: application/json');
  echo json_encode(['added'=>true]);
});

$app->delete('/user', function($data){
  if(empty($data['id']))
    throw new Exception('please proivde an id');
  require_once './Controllers/User.controller.php';
  $user = User::fetch_by_id($data['id']);
  $user->delete();
  header('content-type: application/json');
  echo json_encode(['deleted'=>true]);
});

$app->put('/user', function($data){
  if(empty($data['id']))
    throw new Exception('please provide a valid id');

  $new_data = [];

  if(isset($data['username'])) $new_data['username'] = $data['username'];
  if(isset($data['email'])) $new_data['email'] = $data['email'];
  if(isset($data['password'])) $new_data['password'] = $data['password'];

  require_once './Controllers/User.controller.php'; 
  $user = User::fetch_by_id($data['id']);
  $user->update($new_data);
  header('content-type: application/json');
  echo json_encode(['updated'=>true]);
});
