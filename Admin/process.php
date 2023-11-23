<?php

require('../Authentication/AuthHandler.php');

session_start();

if (isset($_POST['createUser']) || $_POST['action']==='createUser' ) {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $authHandler = new AuthHandler();
    $authHandler->createUser($username, $email, $password, $role);
} else {
    $response = ['error' => 'Missing data'];
    header('Content-Type: application/json');
    echo json_encode($response);
}


error_reporting(E_ALL);
ini_set('display_errors', 1);
