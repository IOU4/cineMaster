<?php
class Controller {
  private $method;
  private $uri;
  function __construct() {
      $this->method = $_SERVER['REQUEST_METHOD'];
      $this->uri = $_SERVER['REQUEST_URI'];
  }

  function get($route, $callable) {
    $parsed_url = parse_url($this->uri);
    $query = [];
    if(isset($parsed_url['query']))
      parse_str($parsed_url['query'], $query);
    if($route == $parsed_url['path'] && $this->method == 'GET') 
        $callable($query);
  }

  function post($route, $callable) {
    $path = parse_url($this->uri)['path'];
    if($route == $path && $this->method == 'POST') {
      $data = $_POST;
      $callable($data);
    }
  }

  function delete($route, $callable) {
    $this->post('/delete'.$route, $callable);
  }

  function put($route, $callable) {
    $this->post('/put'.$route, $callable);
  }
}
