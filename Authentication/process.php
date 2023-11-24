<?php

require('AuthHandler.php');


if (isset($_POST['logIn']) || $_POST['action']==='logIn' ) {
    $email =  $_POST['email'] ;
    $password = $_POST['password'];
    $authHandler = new AuthHandler();
    $authHandler->login( $email, $password);
} else {
    $response = ['error' => 'Missing data'];
    header('Content-Type: application/json');
    echo json_encode($response);
}


error_reporting(E_ALL);
ini_set('display_errors', 1);
