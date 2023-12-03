<?php

require('../Authentication/AuthHandler.php');




$response = [];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'createUser':
                $username =  $_POST['username'];
                $email =  $_POST['email'];
                $password =  $_POST['password'];
                $role =  $_POST['role'];
                $authHandler = new AuthHandler();
                $authHandler->createUser($username, $email, $password, $role);
                break;
            default:
                $response = ['error' => 'Invalid action for POST request'];
                break;
        }
    } else {
        $response = ['error' => 'Missing action for POST request'];
    }
}

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case '#':
                break;

            default:
                $response = ['error' => 'Invalid action for GET request'];
                break;
        }
    } else {
        $response = ['error' => 'Missing action for GET request'];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
error_reporting(E_ALL);
ini_set('display_errors', 1);
