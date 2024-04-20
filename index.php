<?php
//Set error reporting to true, require autoload, start session
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once('vendor/autoload.php');
session_start();

//Instantiate the Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET /info', function () {
    $view = new Template();
    echo $view->render('views/personal-info.html');
});

//Run fat free
$f3->run();
