<?php

require_once '../vendor/autoload.php';

// Заголовки
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

use App\Router;

$router = new Router();

$router->runApi();