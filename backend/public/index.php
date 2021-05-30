<?php

require "../bootstrap.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Routing
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$controllerNamespace = 'Src\\Controller\\';
$controllerName = 'Src\\Controller\\'.ucfirst($uri[1]).'Controller';

if (!class_exists($controllerName)) {
    \Src\Controller\Http\Responses::notFoundResponse();
} else {
    $controller = new $controllerName(Src\Common\DatabaseConnection::getConnection(), $_SERVER["REQUEST_METHOD"]);
    $controller->successfulResponse();
}

