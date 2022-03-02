<?php
include_once './Models/User.model.php';
class User {

  private $id;
  private $username;
  private $email;
  private $password;
  private $created_at;
  private $model;

  function __construct($username, $email, $password, $created_at = null, $id = null) {
    $this->id = $id;
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->created_at = $created_at;
    $this->model = new UserModel();
  }

  function login() {
    $params = array($this->username);
    $res = $this->model->login($params);
    if(isset($res['password']) && $this->password == $res['password']) {
      $_SESSION['user_id'] = $res['id'];
      $_SESSION['username'] = $this->username;
      echo json_encode(['logged'=>true]);
    }
    else 
      echo json_encode(['logged'=>false]);
  }
  
  function singup() {
    $params = array($this->username, $this->email, $this->password);
    // TODO: check for duplication
    try {
      $this->model->singup($params);
      echo json_encode(['logged'=>true]);
    } catch(Exception) {
      echo json_encode(['logged'=>false]);
    }
  }

  function add() {
    $params = array($this->username, $this->email, $this->password);
    $this->id = $this->model->add($params);
  }

  function update($params) {
    $this->username = isset($params['username']) ? $params['username'] : $this->username;
    $this->email = isset($params['email']) ? $params['email'] : $this->email;
    $this->password = isset($params['password']) ? $params['password'] : $this->password;
    $params = [$this->username, $this->email, $this->password, $this->id];
    $this->model->update($params);
  }

  function delete() {
    $params = array($this->id);
    $this->model->delete($params);
  }

  function get_id() {
    return "id => ".$this->id."\xa";
  }

  static function fetch_all() {
    $userModel = new UserModel();
    $result = $userModel->fetch_all();
    return $result;
  }
  
  static function fetch_by_id($id) {
    $userModel = new UserModel();
    $user = $userModel->fetch_by_id($id);
    return new User($user['username'], $user['email'], $user['password'], $user['created_at'], $id);
  }

  static function fetch_by_username($username) {
    $userModel = new UserModel();
    $user = $userModel->fetch_by_username($username);
    return $user;
  }

}

