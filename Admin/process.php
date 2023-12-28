<?php
session_start();
include '../Authentication/AuthHandler.php';
include 'DatabaseHandler.php';


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
                return $authHandler->createUser($username, $email, $password, $role);
                break;
            case 'permanently_remove_user':
                $userId = $_POST['userId']; // Assuming you have a userId in the form data
                $response = $authHandler->permanentlyRemoveUser($userId);
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
            case 'remove_user':
                // Implement logic to remove a user (soft delete or mark as inactive)
                // $userId = $_GET['userId'];
                // $response = $authHandler->removeUser($userId);
                break;
            case 'approve_request':
                $applicationID = $_GET['applicationID'];
                $authHandler = new AuthHandler();
                return $authHandler->approveUserRequest($applicationID, $_SESSION['user_id']);
                break;

            case 'reject_request':
                $applicationID = $_GET['applicationID'];
                $authHandler = new AuthHandler();
                return $authHandler->rejectUserRequest($applicationID, $_SESSION['user_id']);
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
