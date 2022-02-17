<?php 
require_once './Controllers/Global.controller.php';

$app = new Controller();
$app->get('/', function() {
  // echo "welcome to Cine Master API \xa";
  header('content-type: application/json');
  echo json_encode($_GET);
});

$app->get('/posts', function() {
  require_once './Controllers/Posts.controller.php'; 
  header('content-type: application/json');
  echo json_encode(Post::fetch_all());
});

$app->get('/post', function($query) {
  require_once './Controllers/Posts.controller.php'; 
  if(empty($query['id'])) echo "please provide an id";
  else {
    header('content-type: application/json');
    echo json_encode(Post::fetch_one($query['id'])->get_all());
  } 
});

$app->delete('/', function($data){
  if(!isset($data['id'])){
    echo 'no sufficant data';
    return;
  }
  require_once './Controllers/Posts.controller.php'; 
  $post = Post::fetch_one($data['id']);
  $post->delete();
  header('content-type: application/json');
  echo json_encode(['deleted'=>true]);
});

$app->put('/', function($data) {
  $new_data = [];

  if(isset($data['title'])) $new_data['title'] = $data['title'];
  if(isset($data['description'])) $new_data['description'] = $data['description'];
  if(isset($data['comments_count'])) $new_data['comments_count'] = $data['comments_count'];

  require_once './Controllers/Posts.controller.php'; 
  $post = Post::fetch_one($data['id']);
  $post->update($new_data);
  header('content-type: application/json');
  echo json_encode(['updated'=>true]);
});

$app->post('/', function($data) {
  require_once './Controllers/Posts.controller.php'; 
  if(!isset($data['title'], $data['description'], $data['comments_count'])) {
    echo 'no sufficant data';
    return;
  }
  $post = new Post($data['title'], $data['description'], $data['comments_count']);
  $post->add();
});
