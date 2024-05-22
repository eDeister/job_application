<?php
/*
 * Author: Ethan Deister
 * Filename: index.php
 * File desc: A controller page which handles routing, business logic, etc. for the job app. site
 * Assignment: Job App. Part 2
 */

//Set error reporting to true, require autoload & validate.php, start session
ini_set('display_errors',1);
error_reporting(E_ALL);
require_once('vendor/autoload.php');
session_start();


//Instantiate the Base class, controller, and validator
$f3 = Base::instance();
$con = new Controller($f3);


//Define a default route
$f3->route('GET /', function () {
    $GLOBALS["con"]->home();
});

$f3->route('GET|POST /info', function () {
    $GLOBALS["con"]->info();
});

$f3->route('GET|POST /experience', function() {
    $GLOBALS["con"]->experience();
});

$f3->route('GET|POST /mail', function($f3) {
    ($f3->get('SESSION.signed-up') == 'true') ?
        $GLOBALS["con"]->mail() : $f3->reroute('summary');
});

$f3->route('GET /summary', function() {
    $GLOBALS["con"]->summary();
});

//Run fat free
$f3->run();
