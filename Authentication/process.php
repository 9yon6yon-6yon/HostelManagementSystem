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
            case 'forgotpassword':
                $email =  $_POST['email'];
                $authHandler = new AuthHandler();
                return $authHandler->forgotPassword($email);
                break;
            case 'reset-password':
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirm_password'];
                $token = $_POST['token'];

                // Validate the form data
                if (empty($email) || empty($password) || empty($confirmPassword) || empty($token)) {
                    $response = ['error' => 'Please fill in all required fields.'];
                } elseif ($password !== $confirmPassword) {
                    $response = ['error' => 'Password and confirm password do not match.'];
                } else {
                    $authHandler = new AuthHandler();
                    $result = $authHandler->resetPassword($email, $password, $token);

                    if ($result) {
                        $response = ['success' => 'Password reset successful.'];
                    } else {
                        $response = ['error' => 'Failed to reset password.'];
                    }
                }
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
