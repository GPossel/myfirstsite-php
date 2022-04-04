<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
header('Content-type: application/json');

error_reporting(E_ALL);
ini_set("display_errors", 1);

require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('Services');

// routes for the articles endpoint
$router->get('/products', 'ProductService@getAll');
$router->get('/products/(\d+)', 'ProductService@getOne');
$router->put('/products/(\d+)', 'ProductService@update');
$router->post('/products/(\d+)', 'ProductService@post');

$router->post('/users(/\d+)?(/\d+)', 'UserService@login');
$router->get('/users/(\d+)', 'UserService@getOne');
$router->post('/users/create/(\d+)', 'UserService@insert');
$router->delete('/users/(\d+)', 'UserService@delete');

$router->post('/articles?(/\d+)?(/\d+)', 'ArticleService@getAll');
$router->get('/articles/(\d+)', 'ArticleService@getOne');
$router->post('/articles/create/(\d+)', 'ArticleService@insert');
$router->put('/articles/(\d+)', 'ArticleService@update'); // TODO ask how to send item body?
$router->delete('/articles/(\d+)', 'ArticleService@delete');

// Run it!
$router->run();