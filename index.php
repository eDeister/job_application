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

$f3->route('GET|POST /info', function ($f3) {

    //If the form was submitted...
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //TODO: Validate the data
        //(If data is valid) Reroute to the next form page
        $f3->reroute('views/experience.html');
    } else {

        $f3->set('SESSION.default_state', "Washington");
        $f3->set('SESSION.states', array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado",
            "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois",
            "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts",
            "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire",
            "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma",
            "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas",
            "Utah", "Vermont", "Virginia", "West Virginia", "Wisconsin", "Wyoming"
        ));
    }

    $view = new Template();
    echo $view->render('views/personal-info.html');
});

//Run fat free
$f3->run();
