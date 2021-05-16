<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("vendor/autoload.php");
require_once("data-layer.php");
require_once("validation.php");

$f3 = Base :: instance();

$f3 -> route('GET|POST /', function ($f3){
    //initialize variables
    $f3->set('flavors', getFlavors()); //get from model into view
    //$f3->set('name', "");
    //var_dump($_POST);

    if ($_SERVER['REQUEST_METHOD']  == 'POST') {

        if (validName($_POST['name'])) { //if name is valid
            $f3->set('name', $_POST['name']); //save post name to f3
            $_SESSION['name'] = $_POST['name'];

        } else {
            $f3->set('errors[name]', 'Name cannot be empty');
        }

        if (!empty($_POST['flavors'])) { //if flavors array is not empty, reroute
            $f3->set('chosenFlavors', $_POST['flavors[]']);
            $_SESSION['chosenFlavors'] = $_POST['flavors'];

        } else {
            //if flavors array is empty
            $f3->set('errors[flavs]', 'Please select a cupcake flavor');
        }

        if (validName($_POST['name']) && !empty(validName($_POST['name']))) {
            $_SESSION['numberOfCupcakes'] = count($_SESSION['chosenFlavors']);
            header('location: summary');
        }

    }

    $view = new Template();
    echo $view -> render("views/home.html");

});

$f3 -> route('GET /summary', function ($f3){
    //initialize variables
    //var_dump($_SESSION);
    $f3->set('price', $_SESSION["numberOfCupcakes"] * 3.50);

    $view = new Template();
    echo $view -> render("views/summary.html");
});

//Run fat free
$f3->run();