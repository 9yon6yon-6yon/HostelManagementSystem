<?php
require_once('../assets/db/db-config.php');
include_once('SetupMail.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer-6.9.1/src/PHPMailer.php';
require_once '../PHPMailer-6.9.1/src/SMTP.php';
require_once '../PHPMailer-6.9.1/src/Exception.php';


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
    }
    public function signout()
    {
        session_start();
        session_unset();
        session_destroy();
        return;
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
        // Implement logic to permanently remove a user
        // Return success or error message
    }

    public function acceptUserRequest($userId)
    {
        // Implement logic to accept a user request
        // Return success or error message
    }

    public function cancelUserRequest($userId)
    {
        // Implement logic to cancel a user request
        // Return success or error message
    }
    public function approveApplication($applicationId, $approverId)
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
            // Application not found or already approved/canceled
            mysqli_stmt_close($checkStmt);
            return false;
        }

        // Update the application status to 'approved' and set the approver
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

        return true;
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
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
