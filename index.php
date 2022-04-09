<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');


require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Config/Connection.php';

$router = new \Bramus\Router\Router();

$router->post('/task', function () {
  $TaskController = new App\Controllers\TasksController;
  $TaskController->task_status();
});

$router->get('/', function () {
  $TaskController = new App\Controllers\TasksController;
  $TaskController->get_all();
});

$router->get('/(\d+)', function ($id) {
  $TaskController = new App\Controllers\TasksController;
  $TaskController->get($id);
});

$router->post('/', function () {
  $TaskController = new App\Controllers\TasksController;
  $TaskController->create();
});

$router->put('/', function () {
  $TaskController = new App\Controllers\TasksController;
  $TaskController->change();
});

$router->delete('/(\d+)', function ($id) {
  $TaskController = new App\Controllers\TasksController;
  $TaskController->delete($id);
});


$router->run();