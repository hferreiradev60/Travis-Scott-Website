<?php

spl_autoload_register(function ($class) {
    include '../app/controllers/' . $class . '.php';
});

$url = isset($_GET['url']) ? explode('/', $_GET['url']) : [];

if ($url[0] === 'home' && empty($url[1])) {
    $controller = new homeController();
    $controller->index();
    exit();
}

$controllerName = empty($url) ? 'homeController' : ucfirst($url[0]) . 'Controller';
$controller = new $controllerName();

$method = isset($url[1]) ? $url[1] : 'index';
$controller->$method();
