<?php

session_start();
header('content-type: application/json');

spl_autoload_register(function ($class_name) {
    include 'Controllers/'.$class_name.'.controller.php';
});

$app = new Controller();

$app->get('/is_logged', function () {
    User::is_logged();
});

$app->post('/login', function ($data) {
    $login = new User($data['username'], null, $data['password']);
    $login->login($data);
});

$app->post('/singup', function ($data) {
    if (!isset($data['username'], $data['email'], $data['password'])) {
        die(json_encode((['error' => 'no enough data provided'])));
    }
    $login = new User($data['username'], $data['email'], $data['password']);
    $login->singup();
});

$app->get('/logout', function () {
    session_destroy();
    echo json_encode(['logged_out'=>true]);
});

$app->get('/', function () {
    echo json_encode(['message'=>'welcome to CineMaster API']);
});

$app->get('/posts', function ($query) {
    if (!empty($query['author'])) {
        echo json_encode(Post::fetch_by_user($query['author']));
    } else {
        echo json_encode(Post::fetch_all());
    }
});

$app->get('/post', function ($query) {
    if (empty($query['id'])) {
        throw new Exception('please provide a valid id ');
    }
    if (!empty($query['id'])) {
        echo json_encode(Post::fetch_by_id($query['id']));
    }
});

$app->get('/users', function () {
    echo json_encode(User::fetch_all());
});

$app->get('/user', function ($query) {
    if (empty($query['username'])) {
        throw new Exception('please proivde a username');
    }
    echo json_encode(User::fetch_by_username($query['username']));
});

$app->get('/comments', function () {
    echo json_encode(Comment::fetch_all());
});

$app->get('/comments/post', function ($query) {
    if (empty($query['post_id'])) {
        throw new Exception('please proivde a post id');
    }
    echo json_encode(Comment::fetch_by_post($query['post_id']));
});

$app->post('/add/post', function ($data) {
    if (!isset($data['title'], $data['description'])) {
        throw new Exception("please provide a valid post id");
    }

    $post = new Post($_SESSION['user_id'], $data['title'], $data['description']);
    $post->add();
});

$app->post('/delete/post', function ($data) {
    if (!isset($data['id'])) {
        throw new Exception('please provide a valid id');
    }
    $post = new Post(null, null, null, null, null, null, $data['id']);
    $post->delete();
    echo json_encode(['deleted'=>true]);
});

$app->post('/update/post', function ($data) {
    if (empty($data['id'])) {
        throw new Exception('please provide a valid id');
    }

    $new_data = [];

    if (isset($data['title'])) {
        $new_data['title'] = $data['title'];
    }
    if (isset($data['description'])) {
        $new_data['description'] = $data['description'];
    }
    if (isset($data['likes_count'])) {
        $new_data['likes_count'] = $data['likes_count'];
    }

    $post = Post::fetch_by_id($data['id']);
    $post = new Post(null, null, null, null, null, null, $data['id']);
    $post->update($new_data);
    echo json_encode(['updated'=>true]);
});

// comments ------------------------------
$app->post('/add/comment', function ($data) {
    if (!isset($data['post_id'], $data['content'])) {
        throw new Exception('please provide post_id, author_id and a content');
    }
    $comment = new Comment($_SESSION['user_id'], $data['post_id'], $data['content']);
    $comment->add();
});

$app->post('/delete/comment', function ($data) {
    if (empty($data['id'])) {
        throw new Exception('please proivde an id');
    }
    $comment = Comment::fetch_by_id($data['id']);
    $comment->delete();
    echo json_encode(['deleted'=>true]);
});

$app->post('/update/comment', function ($data) {
    if (empty($data['id'])) {
        throw new Exception('please provide a valid id');
    }

    $new_data = [];
    if (isset($data['content'])) {
        $new_data['content'] = $data['content'];
    }

    $comment = Comment::fetch_by_id($data['id']);
    $comment->update($new_data);
    echo json_encode(['updated'=>true]);
});

// useres ---------------------------
$app->post('/add/user', function ($data) {
    if (!isset($data['username'], $data['email'], $data['password'])) {
        throw new Exception('please provide post_id, author_id and a content');
    }
    $user = new User($data['username'], $data['email'], $data['password']);
    $user->add();
    echo json_encode(['added'=>true]);
});

$app->post('/delete/user', function ($data) {
    if (empty($data['id'])) {
        throw new Exception('please proivde an id');
    }
    $user = User::fetch_by_id($data['id']);
    $user->delete();
    echo json_encode(['deleted'=>true]);
});

$app->post('/update/user', function ($data) {
    if (empty($data['id'])) {
        throw new Exception('please provide a valid id');
    }

    $new_data = [];
    if (isset($data['username'])) {
        $new_data['username'] = $data['username'];
    }
    if (isset($data['email'])) {
        $new_data['email'] = $data['email'];
    }
    if (isset($data['password'])) {
        $new_data['password'] = $data['password'];
    }
    $user = User::fetch_by_id($data['id']);
    $user->update($new_data);
    echo json_encode(['updated'=>true]);
});
