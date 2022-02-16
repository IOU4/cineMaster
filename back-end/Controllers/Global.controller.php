<?php
class Controller {
  private $method;
  private $uri;
  function __construct() {
      $this->method = $_SERVER['REQUEST_METHOD'];
      $this->uri = $_SERVER['REQUEST_URI'];
  }

  function get($route, $callable) {
    if($route == $this->uri && $this->method == 'GET') 
      $callable();
  }

  function delete($route, $callable) {
    $this->post('/delete'.$route, $callable);
  }

  function put($route, $callable) {
    $this->post('/put'.$route, $callable);
  }

  function post($route, $callable) {
    if($route == $this->uri && $this->method == 'POST') {
      $data = $_POST;
      $callable($data);
    }
  }
}
