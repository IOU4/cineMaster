<?php 
require_once './Controllers/Global.controller.php';

$app = new Controller();
$app->get('/', function() {
  echo "hi there";
});
