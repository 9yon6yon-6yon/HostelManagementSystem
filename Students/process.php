<?php
session_start();
include '../Authentication/AuthHandler.php';

$response = [];

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
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
            case 'pay':
                $authHandler = new AuthHandler();
                $moneyAmount = floatval($_POST['amount']);
                $post_data['store_id'] = "6yon65967ec9e7752";
                $post_data['store_passwd'] = "6yon65967ec9e7752@ssl";
                $post_data['total_amount'] = $moneyAmount;
                $post_data['currency'] = "BDT";
                $post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();
                $post_data['success_url'] = "http://localhost/HostelManagementSystem/Students/success.php";
                $post_data['fail_url'] = "http://localhost/HostelManagementSystem/Students/fail.php";
                $post_data['cancel_url'] = "http://localhost/HostelManagementSystem/Students/payment.php";

                $post_data['cus_name'] =  $authHandler->getUserName($_SESSION['user_id']);
                $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php";

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $direct_api_url);
                curl_setopt($handle, CURLOPT_TIMEOUT, 30);
                curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($handle, CURLOPT_POST, 1);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);


                $content = curl_exec($handle);

                $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                if ($code == 200 && !(curl_errno($handle))) {
                    curl_close($handle);
                    $sslcommerzResponse = $content;
                } else {
                    curl_close($handle);
                    $response = ['error' => 'FAILED TO CONNECT WITH SSLCOMMERZ API '];
                    exit;
                }
                $sslcz = json_decode($sslcommerzResponse, true);

                if ($sslcz === null && json_last_error() !== JSON_ERROR_NONE) {
                    $response = ['error' => 'JSON Decode Error: ' . json_last_error_msg()];
                } elseif (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
                    $response = ['success' => 'Payment successful', 'GatewayPageURL' => $sslcz['GatewayPageURL']];
                    # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                    # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                    # echo "<meta http-equiv='refresh' content='0;url=" . $sslcz['GatewayPageURL'] . "'>";
                    #header("Location: " . $sslcz['GatewayPageURL']);

                } else {
                    $response = ['error' => 'JSON Data parsing error!'];
                }
                break;
            case 'success-pay':
                session_start();
                $id = $_SESSION['user_id'];
                $amount = $_POST['amount'];
                $tran_id = $_POST['tran_id'];
                $authHandler = new AuthHandler();
                return $authHandler->paynow($id, $amount, $tran_id);
                break;
            case 'fail-pay':
                session_start();
                break;
            case 'seat-book':
                $id = $_SESSION['user_id'];
                $seat_id = $_POST['seat_no'];
                $start = $_POST['start'];
                $end = $_POST['end'];
                if ($start > $end) {
                    $response = ["error" => "Start date cannot be after end date"];
                    break;
                }
                $authHandler = new AuthHandler();
                return $authHandler->add_seat_allocation_request($seat_id, $id, $start, $end);
                break;
            case 'renew-room':
                $id = $_SESSION['user_id'];
                $sa_id = $_POST['sa_id'];
                $start = $_POST['start'];
                $end = $_POST['end'];
                if ($start > $end) {
                    $response = ["error" => "Start date cannot be after end date"];
                    break;
                }
                $authHandler = new AuthHandler();
                return $authHandler->renew_seat_allocation($sa_id, $id, $start, $end);
                break;
            case 'room-cancel':
                $id = $_SESSION['user_id'];
                $sa_id = $_POST['sa_id'];
                $authHandler = new AuthHandler();
                return $authHandler->cancel_seat_application($sa_id, $id);
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
            case 'load-room':
                $authHandler = new AuthHandler();
                return $authHandler->rooms();
                break;
            case 'load-room-allocation':
                $id = $_SESSION['user_id'];
                $authHandler = new AuthHandler();
                return $authHandler->seat_application_of_user($id);
                break;
            case 'load-cancel-allocation':
                $id = $_SESSION['user_id'];
                $authHandler = new AuthHandler();
                return $authHandler->seat_application_of_user_pending($id);
                break;
            case 'load-seat':
                if (isset($_GET['room_id'])) {
                    $room_id = $_GET['room_id'];
                    $authHandler = new AuthHandler();
                    return $authHandler->seats($room_id);
                } else {
                    $response = ['error' => 'Missing room_id parameter for load-seat action'];
                }
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
header('Access-Control-Allow-Origin: *');
echo json_encode($response);
error_reporting(E_ALL);
ini_set('display_errors', 1);
