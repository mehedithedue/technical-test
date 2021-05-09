<?php

use Controller\Controller;

include_once '../vendor/autoload.php';
include_once 'config/config.php';

$router = new \Router\Router();

$router->route('/category', function () {
    return Controller::category();
});

$router->route('/documents', function () {
    return Controller::getDocuments();
});

$router->route('/show-document', function () {
    return Controller::showDocument();
});

$router->route('/document-create', function () {
    return Controller::createDocuments();
});

$router->route('/document-edit', function () {
    return Controller::editDocuments();
});
$router->route('/document-delete', function () {
    return Controller::deleteDocuments();
});
$action = $_SERVER['REQUEST_URI'];
$router->dispatch($action);