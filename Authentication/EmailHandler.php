<?php

require_once('SetupMail.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHandler
{
    public static function sendConfirmationEmail($username, $email, $password, $role)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->SMTPDebug = 2;                 
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
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
