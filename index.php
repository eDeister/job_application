<?php
//Set error reporting to true
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require autoload
require_once('vendor/autoload.php');

//Instantiate the Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /',
    function () {
        $view = new Template();
        echo $view->render('views/home.html');
    }
);

//Run fat free
$f3->run();
