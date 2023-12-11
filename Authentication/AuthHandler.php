<?php

require_once('../assets/db/db-config.php');
require_once('SetupMail.php');

require ('./PHPMailer/src/PHPMailer.php');
require ('./PHPMailer/src/SMTP.php');
require ('./PHPMailer/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class AuthHandler
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }
    private function sendConfirmationEmail($username, $email, $password, $role)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();  
            $mail->Host = MailSetup::$SMTP_HOST; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = MailSetup::$SMTP_USERNAME; // SMTP username
            $mail->Password = MailSetup::$SMTP_PASSWORD; // SMTP password
            $mail->SMTPSecure = MailSetup::$SMTP_ENCRYPTION; // Enable encryption
            $mail->Port = MailSetup::$SMTP_PORT; // TCP port to connect to
            $mail->setFrom(MailSetup::$SMTP_FROM_ADDRESS, "City University");
            $mail->addAddress($email, $username); // Add a recipient

            // Email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Welcome to Your Website';

            // Customized HTML email content
            $mail->Body = "
            <p>Hello $username,</p>
            <p>Welcome to Your Website! We are excited to have you on board.</p>
            <p>Feel free to explore our platform and let us know if you have any questions.</p><br>
            <p>Name: $username.<br>Email: $email <br>Password: $password <br>Role: $role</p>
            <p>Feel free to explore our platform and let us know if you have any questions.</p>
            <p>Best regards,<br>Admin</p>
        ";

            $mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
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

        if ($hashedPassword !== null && password_verify($password, $hashedPassword)) {
            $userRole = $this->getUserRole($email);

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
            session_start();
            $_SESSION['userRole'] = $userRole;
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
                $this->sendConfirmationEmail($username, $email, $password, $role);
                $response = ['success' => 'User created successfully and email has been sent.'];
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
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
