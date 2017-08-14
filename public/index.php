<?php
spl_autoload_register(function ($class_name) {
    require_once '../src/' . $class_name . '.php';
});

$controller = isset($_GET['c'] ) ? $_GET['c'] : '';
$action = isset($_GET['a']) ? $_GET['a'] :'';



if(!$controller) {
    $trees = MenuTree::getMenuTree();
    $trees = json_encode($trees);
    include 'index.html';

} else {
    $controller = new $controller();
    $controller->$action();
}