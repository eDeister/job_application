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
require_once('model/validate.php');
session_start();

//Instantiate the Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});
$f3->route('GET /home', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /info', function ($f3) {

    //Set states array for dropdown option
    $f3->set('SESSION.default_state', "Washington");
    $f3->set('SESSION.states', array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado",
        "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois",
        "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts",
        "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire",
        "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma",
        "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas",
        "Utah", "Vermont", "Virginia", "West Virginia", "Wisconsin", "Wyoming"
    ));

    //If the form was submitted...
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get data
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $state = $_POST['state'];
        $phone = $_POST['phone'];

        //Validate data
        $validName = validName($fname) && validName($lname);
        $validEmail = validEmail($email);
        $validPhone = validPhone($phone);

        //If data valid...
        if ($validName && $validEmail && $validPhone) {
            //Add data to the session
            $f3->set('SESSION.fname',$fname);
            $f3->set('SESSION.lname',$lname);
            $f3->set('SESSION.email',$email);
            $f3->set('SESSION.state',$state);
            $f3->set('SESSION.phone',$phone);

            //Reroute to the next form page
            $f3->reroute('experience');
        //Otherwise...
        } else {
            $errors = array();
            //Set errors
            if(!$validName) {
                $errors[] = 'name';
            }
            if (!$validEmail) {
                $errors[] = 'email';
            }
            if (!$validPhone) {
                $errors[] = 'phone';
            }
            $f3->set('SESSION.errors', $errors);
        }

    }

    $view = new Template();
    echo $view->render('views/personal-info.html');
});

$f3->route('GET|POST /experience', function($f3) {

    //If the form was submitted...
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get data
        $bio = $_POST['bio'];
        $github = $_POST['github'];
        $years = $_POST['years'];
        $reloc = $_POST['reloc'];

        //TODO: Validate the data
        //Add data to the session
        $f3->set('SESSION.bio',$bio);
        $f3->set('SESSION.github',$github);
        $f3->set('SESSION.years',$years);
        $f3->set('SESSION.reloc',$reloc);
        //Reroute to the next page
        $f3->reroute('mail');
    } else {

    }
    $view = new Template();
    echo $view->render('views/experience.html');
});

$f3->route('GET|POST /mail', function($f3) {

    //If the form was submitted...
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //Get data
        $jobs = $_POST['jobs'];
        $verticals = $_POST['verticals'];

        //TODO: Validate the data
        //Add data to the session
        $f3->set('SESSION.jobs',$jobs);
        $f3->set('SESSION.verticals',$verticals);

        //(If the data is valid) Reroute to the next page
        $f3->reroute('summary');
    } else {

    }
    $view = new Template();
    echo $view->render('views/mailing-list.html');
});

$f3->route('GET /summary', function($f3) {
    $view = new Template();
    echo $view->render('views/summary.html');
});

//Run fat free
$f3->run();
