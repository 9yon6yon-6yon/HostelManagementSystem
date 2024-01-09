<?php
require_once('../assets/db/db-config.php');
include_once('SetupMail.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer-6.9.1/src/PHPMailer.php';
require_once '../PHPMailer-6.9.1/src/SMTP.php';
require_once '../PHPMailer-6.9.1/src/Exception.php';

date_default_timezone_set('asia/dhaka');

class AuthHandler
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }


    public function login($email, $password)
    {
        if ($email === 'admin@city.hostel.com' && $password === 'admin') {
            $response = ['redirect' => '../Admin/dashboard.php'];
            session_start();
            $_SESSION['userRole'] = 'admin';
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }
        $hashedPassword = $this->getHashedPassword($email);
        session_start();
        if ($hashedPassword !== null && password_verify($password, $hashedPassword)) {
            $userRole = $this->getUserRole($email);
            $user_id = $this->getUserId($email);

            switch ($userRole) {
                case 'admin':
                    $response = ['redirect' => '../Admin/dashboard.php'];
                    break;
                case 'student':
                    $response = ['redirect' => '../Students/dashboard.php'];
                    break;
                case 'provost':
                    $response = ['redirect' => '../Provost/dashboard.php'];
                    break;
                case 'hallsuper':
                    $response = ['redirect' => '../HostelSuper/dashboard.php'];
                    break;
                case 'accounts':
                    $response = ['redirect' => '../Accounts/dashboard.php'];
                    break;

                default:
                    $response = ['error' => 'Invalid credentials'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return false;
            }

            $_SESSION['userRole'] = $userRole;
            $_SESSION['user_id'] = $user_id;
            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit();
        }

        // Password is incorrect or user does not exist
        $response = ['error' => 'Invalid credentials'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }



    public function createUser($username, $email, $password, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (name, mail, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                $emailSent = $this->sendConfirmationEmail($username, $email, $password, $role);

                if (!$emailSent) {
                    $response = ['success' => 'User created successfully.'];
                } else {
                    $response = ['error' => 'User created, but failed to send confirmation email.'];
                }
            } else {
                $response = ['error' => 'Failed to create user'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            return $result;
        }

        $response = ['error' => 'Failed to create user'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }

    private function sendConfirmationEmail($username, $email, $password, $role)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = MailSetup::$SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MailSetup::$SMTP_USERNAME;
            $mail->Password = MailSetup::$SMTP_PASSWORD;
            $mail->SMTPSecure = MailSetup::$SMTP_ENCRYPTION;
            $mail->Port = MailSetup::$SMTP_PORT;
            $mail->setFrom(MailSetup::$SMTP_FROM_ADDRESS, "City University");
            $mail->addAddress($email, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Your Website';
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0; max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);'>
                <h1 style='margin: 0; color: #3498db;'>Hi, $username,</h1>
                <p>Welcome to <span style='color: red;'>City University Hostel</span>! We are excited to have you on board.</p>
                <p>Feel free to explore our platform, and let us know if you have any questions.</p>
                <p><strong>Name:</strong> $username<br><strong>Email:</strong> $email <br><strong>Password:</strong> $password <br><strong>Role:</strong> $role</p>
                <div style='margin-top: 20px;'>
                    <p style='font-style: italic; color: #888;'>Best regards,<br>Admin of City University Hostel</p>
                </div>
            </div>
        ";
            $mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            throw new Exception("Failed to send confirmation email.");
        }
    }
    public function forgotPassword($email)
    {

        $userId = $this->getUserId($email);

        if (!$userId) {

            $hashedPassword = password_hash('password', PASSWORD_DEFAULT);

            $query = "INSERT INTO users (name, mail, password) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);

            if ($stmt) {
                $name = 'Guest';
                $stmt->bind_param("sss", $name, $email, $hashedPassword);
                $result = $stmt->execute();
                $stmt->close();
            }
            if (!$result) {
                $response = ['error' => 'Failed to create user'];
                header('Content-Type: application/json');
                echo json_encode($response);
                return false;
            }

            // ID of the newly created user
            $userId = $this->getUserId($email);
        }
        // Generate password reset token
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        // Insert the password reset token into the database
        $query = "INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("iss", $userId, $token, $expiresAt);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                // Send the reset link to the user's email
                $emailSent = $this->sendResetLink($email, $token);

                if (!$emailSent) {
                    $response = ['success' => 'Reset link sent to your email.'];
                } else {
                    $response = ['error' => 'Failed to send reset link to your email.'];
                }
            } else {
                $response = ['error' => 'Failed to create password reset token.'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);

            return $result;
        }

        return false;
    }
    private function sendResetLink($email, $token)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = MailSetup::$SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MailSetup::$SMTP_USERNAME;
            $mail->Password = MailSetup::$SMTP_PASSWORD;
            $mail->SMTPSecure = MailSetup::$SMTP_ENCRYPTION;
            $mail->Port = MailSetup::$SMTP_PORT;
            $mail->setFrom(MailSetup::$SMTP_FROM_ADDRESS, "City University");
            $mail->addAddress($email, 'Guest');
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link';
            $mail->Body = "
            <div style='font-size: 18px; width:90%; max-width: 600px; margin: 5px auto 35px auto;'>
                <div style='margin-bottom: 10px;'>Hi!</div>
                <div>You requested to recover your account on <span style='color: red;'>City University Hostel</span>. To reset your account password, please follow the link
                    below:</div>
                <div style='margin-top: 25px; text-align:center;'>
                    <a href='http://localhost/HostelManagementSystem/Authentication/resetPassword.php?token=$token&email=$email'
                        style='background:
                        #009688; text-transform: uppercase; border-radius:3px; padding: 5px 14px; color: white; border: 1px
                        solid #009688; font-size:17px; font-weight: bold; text-decoration: none;'>Reset Password</a>
                </div>
            </div>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            throw new Exception("Failed to send confirmation email.");
        }
    }
    public function signout()
    {
        session_start();
        session_unset();
        session_destroy();
        return;
    }
    public function resetPassword($email, $newPassword, $token)
    {
        // Check if the token is valid
        $query = "SELECT user_id FROM password_reset_tokens WHERE user_id = (SELECT id FROM users WHERE mail = ?) AND token = ? AND expires_at > NOW()";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {
                $stmt->close();
                error_log("Invalid token for email: $email and token: $token");
                return false; // Invalid token
            }
            $stmt->close();
        } else {
            error_log("Query preparation failed for resetPassword");
            return false; // Query preparation failed
        }

        // Token is valid, proceed to update the password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = ? WHERE mail = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $hashedPassword, $email);
            $result = $stmt->execute();
            $stmt->close();

            // Remove the used token
            $this->removeToken($email, $token);

            if ($result) {
                error_log("Password reset successful for email: $email");
            } else {
                error_log("Failed to reset password for email: $email");
            }

            return $result;
        }

        error_log("Query preparation failed for updating password");
        return false;
    }

    private function removeToken($email, $token)
    {
        $query = "DELETE FROM password_reset_tokens WHERE user_id = (SELECT id FROM users WHERE mail = ?) AND token = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $email, $token);
            $stmt->execute();
            $stmt->close();
        }
    }
    public function updatePassword($email, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = ? WHERE mail = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ss", $hashedPassword, $email);
            $result = $stmt->execute();
            $stmt->close();

            return $result;
        }

        return false;
    }

    private function getHashedPassword($email)
    {
        $query = "SELECT password FROM users WHERE mail = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);

            if ($stmt->fetch()) {
                $stmt->close();
                return $hashedPassword;
            }
        }

        return null;
    }
    private function getUserRole($email)
    {
        $query = "SELECT role FROM users WHERE mail = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($userRole);

            if ($stmt->fetch()) {
                $stmt->close();
                return $userRole;
            }
        }

        return null;
    }
    private function getUserId($email)
    {
        $query = "SELECT id FROM users WHERE mail = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($user_id);

            if ($stmt->fetch()) {
                $stmt->close();
                return $user_id;
            }
        }

        return null;
    }
    public function permanentlyRemoveUser($userId)
    {
        $query = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $userId);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $response = ['success' => 'User deleted'];
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
        $response = ['success' => 'Can\'t delete user'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }


    public function getUserName($userId)
    {
        $query = "SELECT name FROM users WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $name = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return $name ? $name['name'] : "N/A";
    }

    public function approveUserRequest($applicationId, $approverId)
    {

        $checkQuery = "SELECT * FROM applications WHERE application_id = ? AND status = 'pending'";
        $checkStmt = mysqli_prepare($this->db, $checkQuery);

        if (!$checkStmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($checkStmt, "i", $applicationId);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        $rowCount = mysqli_stmt_num_rows($checkStmt);

        if ($rowCount === 0) {
            mysqli_stmt_close($checkStmt);
            return false;
        }

        $updateQuery = "UPDATE applications SET status = 'approved', approved_by = ? WHERE application_id = ?";
        $updateStmt = mysqli_prepare($this->db, $updateQuery);

        if (!$updateStmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($updateStmt, "ii", $approverId, $applicationId);
        $updateResult = mysqli_stmt_execute($updateStmt);

        if (!$updateResult) {
            die("Error updating application: " . mysqli_error($this->db));
        }

        mysqli_stmt_close($checkStmt);
        mysqli_stmt_close($updateStmt);

        $response = ['success' => 'Request approved'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return true;
    }
    public function rejectUserRequest($applicationID, $rejecterId)
    {
        $checkQuery = "SELECT * FROM applications WHERE application_id = ? AND status = 'pending'";
        $checkStmt = mysqli_prepare($this->db, $checkQuery);

        if (!$checkStmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($checkStmt, "i", $applicationID);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);

        $rowCount = mysqli_stmt_num_rows($checkStmt);

        if ($rowCount === 0) {
            mysqli_stmt_close($checkStmt);
            return false;
        }

        $updateQuery = "UPDATE applications SET status = 'canceled', approved_by = ? WHERE application_id = ?";
        $updateStmt = mysqli_prepare($this->db, $updateQuery);

        if (!$updateStmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($updateStmt, "ii", $rejecterId, $applicationID);
        $updateResult = mysqli_stmt_execute($updateStmt);

        if (!$updateResult) {
            die("Error updating application: " . mysqli_error($this->db));
        }

        mysqli_stmt_close($checkStmt);
        mysqli_stmt_close($updateStmt);

        $response = ['success' => 'Rejected users application'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return true;
    }
    public function makeAnnouncement($id, $title, $visibility, $description)
    {
        $date = date('Y-m-d H:i:s.u');
        $query = "INSERT INTO notice ( title, description, visibility,date, updated_by) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssssi", $title, $description, $visibility, $date, $id);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                $response = ['success' => 'Announcement Added Successfully'];
            } else {
                $response = ['error' => 'Failed to make announcement.'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);

            return $result;
        }
        $response = ['error' => 'Failed to make announcement '];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }
    public function requestPayment($id, $paymentInfo)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = MailSetup::$SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = MailSetup::$SMTP_USERNAME;
            $mail->Password = MailSetup::$SMTP_PASSWORD;
            $mail->SMTPSecure = MailSetup::$SMTP_ENCRYPTION;
            $mail->Port = MailSetup::$SMTP_PORT;
            $mail->setFrom(MailSetup::$SMTP_FROM_ADDRESS, "City University");
            $mail->addAddress($paymentInfo['user_email'], $paymentInfo['user_name']);
            $mail->isHTML(true);
            $mail->Subject = 'Requesing to clear payment';
            $mail->Body = "
            <div style='font-size: 18px; width:90%; max-width: 600px; margin: 5px auto 35px auto;'>
                <div style='margin-bottom: 10px;'>Hi {$paymentInfo['user_name']} !</div>
                <div>You are requested to clear your due on <span style='color: red;'>City University Hostel</span>. Please log in to your account and clear your payment or visit the accounts section</div>
        
            </div>
            ";

            $mail->send();
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            throw new Exception("Failed to send confirmation email.");
        }
    }
    public function approvePayment($id)
    {
        $query = "UPDATE payment SET status = ? WHERE payment_id = ?";
        $stmt = $this->db->prepare($query);
        $status = 'paid';
        if ($stmt) {
            $stmt->bind_param("si", $status, $id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $response = ['success' => 'Payment approved Successfully'];
            } else {
                $response = ['error' => 'Failed to approve Payment.'];
            }

            header('Content-Type: application/json');
            echo json_encode($response);

            return $result;
        }
        $response = ['error' => 'Failed to approve payment updated request '];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }
    public function getUserInfo($id)
    {
        $query = "SELECT id, name, mail, role, is_active, verified, user_info.* FROM users 
                  LEFT JOIN user_info ON (users.id = user_info.usr) WHERE users.id = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
        header('Content-Type: application/json');
        echo json_encode($user);
        return true;
    }
    public function changePassword($id, $currentPassword, $newPassword)
    {
        $query = "SELECT mail FROM users WHERE id =?";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $mail = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        $hashedPassword = $this->getHashedPassword($mail['mail']);

        if ($hashedPassword !== null && password_verify($currentPassword, $hashedPassword)) {
            $hashNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashNewPassword, $id);

            if ($stmt->execute()) {
                $response = ['success' => 'Password updated successfully.'];
            } else {
                $response = ['error' => 'Failed to update password.'];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            return true;
        }
        $response = ['error' => 'Failed to change password'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }
    public function paynow($id, $amount, $tx_id)
    {
        $query = "INSERT INTO payment (user, amount, status, date, transaction_id) VALUES (?, ?, 'pending', NOW(),?)";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ids", $id, $amount, $tx_id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                $response = ['success' => 'Payment details saved successfully'];
            } else {
                $response = ['error' => 'Failed to save payment details.'];
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        } else {
            $response = ['error' => 'Failed to prepare the SQL statement.'];
        }
        $response = ['error' => 'Failed to pay'];
        header('Content-Type: application/json');
        echo json_encode($response);
        return false;
    }
    public function rooms(){
        $query = "SELECT room.room_id, room.room_no, room.status, building.building_name
        FROM room
        LEFT JOIN building ON room.building_id = building.building_id";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            $rooms = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();


            header('Content-Type: application/json');
            echo json_encode($rooms);
        } else {

            http_response_code(500);
            echo json_encode(array("error" => "Failed to prepare statement"));
        }
        
    }
    public function seats($room_id){
        $query = "SELECT seats.seat_id, seats.status, room.room_no
        FROM seats
        JOIN room ON seats.room_no = room.room_id
        WHERE seats.room_no = ?";
        $stmt = $this->db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $room_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $seats = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            header('Content-Type: application/json');
            echo json_encode($seats);
        } else {

            http_response_code(500);
            echo json_encode(array("error" => "Failed to prepare statement"));
        }
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
