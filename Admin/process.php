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
                $userId = $_POST['userId'];
                $authHandler = new AuthHandler();
                return $authHandler->permanentlyRemoveUser($userId);
                break;
            case 'make-notice':
                $id = $_SESSION['user_id'];
                $title = $_POST['title'];
                $visibility = $_POST['visibility'];
                $description = $_POST['description'];
                $authHandler = new AuthHandler();
                return $authHandler->makeAnnouncement($id, $title, $visibility, $description);
                break;
            case 'room-approve':
                $id = $_POST['sa_id'];
                $authHandler = new AuthHandler();
                return $authHandler->approve_seat_allocation_request($id);
                break;
            case 'requestPayment':
                $id = $_POST['paymentId'];
                $databaseHandler = new DatabaseHandler();
                $paymentInfo = $databaseHandler->getPaymentInfo($id);
                $authHandler = new AuthHandler();
                return $authHandler->requestPayment($id, $paymentInfo);
                break;
            case 'approvePayment':
                $id = $_POST['paymentId'];
                $authHandler = new AuthHandler();
                return $authHandler->approvePayment($id);
                break;
            case 'change-password':
                $id = $_SESSION['user_id'];
                $currentPassword = $_POST['currentPassword'];
                $newPassword = $_POST['newPassword'];
                $renewPassword = $_POST['renewPassword'];
                if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
                    $response = ['error' => 'Please fill in all required fields.'];
                } elseif ($newPassword !== $renewPassword) {
                    $response = ['error' => 'Password and Re-enter New Password does not match.'];
                } else {
                    $authHandler = new AuthHandler();
                    $response = $authHandler->changePassword($id, $currentPassword, $newPassword);
                }
                return $response;
                break;
            case 'load-user':
                $id = $_SESSION['user_id'];
                $authHandler = new AuthHandler();
                return $authHandler->getUserInfo($id);
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
            case 'load-allocation-table':
                $authHandler = new AuthHandler();
                return $authHandler->seat_application_of_all_pending();
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
