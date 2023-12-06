<?php

require('AuthHandler.php');

$response = [];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'signout':
                $authHandler = new AuthHandler();
                $authHandler->signout();
                $response = ['success' => 'Signed out successfully'];
                break;
            case 'logIn':
                $email =  $_POST['email'];
                $password = $_POST['password'];
                $authHandler = new AuthHandler();
                $authHandler->login($email, $password);
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

error_reporting(E_ALL);
ini_set('display_errors', 1);
