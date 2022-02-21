<?php 
require_once './Controllers/Global.controller.php';

$app = new Controller();
$app->get('/', function() {
  header('content-type: application/json');
  echo json_encode(['message'=>'welcome to CineMaster API']);
});

$app->get('/posts', function() {
  require_once './Controllers/Posts.controller.php'; 
  header('content-type: application/json');
  echo json_encode(Post::fetch_all());
});

$app->get('/post', function($query) {
  if(empty($query['id'])) 
    throw new Exception('please provide a valid id');
  else {
    require_once './Controllers/Posts.controller.php'; 
    header('content-type: application/json');
    echo json_encode(Post::fetch_one($query['id'])->get_all());
  } 
});

$app->delete('/post', function($data){
  if(!isset($data['id']))
    throw new Exception('please provide a valid id');
  require_once './Controllers/Posts.controller.php'; 
  $post = Post::fetch_one($data['id']);
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

  require_once './Controllers/Posts.controller.php'; 
  $post = Post::fetch_one($data['id']);
  $post->update($new_data);
  header('content-type: application/json');
  echo json_encode(['updated'=>true]);
});

$app->post('/post/add', function($data) {
  if(!isset($data['author_id'], $data['title'], $data['description'], $data['likes_count'])) {
    echo 'no sufficant data';
    return false;
  }
  require_once './Controllers/Posts.controller.php'; 
  $post = new Post($data['author_id'], $data['title'], $data['description'], $data['likes_count']);
  $post->add();
  header('content-type: application/json');
  echo json_encode(['added'=>true]);
});
