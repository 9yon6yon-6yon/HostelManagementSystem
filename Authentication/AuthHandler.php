<?php
require_once('../assets/db/db-config.php');

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
                $response = ['success' => 'User created successfully'];
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
