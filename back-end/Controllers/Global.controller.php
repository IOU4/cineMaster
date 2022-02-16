<?php
class Controller {
  private $method;
  private $uri;

  function get($route, $callable) {
    if($route == $this->uri && $this->method == 'GET') 
      $callable();
  }
  function post($route, $callable) {
    if($route == $this->uri && $this->method == 'GET') {
      $data = $_POST;
      $callable($data);
    }
  }
}
