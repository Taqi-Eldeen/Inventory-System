<?php

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require(dirname(__DIR__, 2) . '/vendor/autoload.php'); 

class EmailService {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);

        // SMTP configuration
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com'; // Change to your SMTP host
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'wizardhavewizard@gmail.com'; // Your email address
        $this->mailer->Password = 'pjwx ollm guer udqs'; // Your app password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587; // Use 587 for TLS or 465 for SSL

        // Default settings
        $this->mailer->setFrom('your_email@gmail.com', 'Your Company');
    }

    public function sendEmail($to, $subject, $body) {
        try {
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;
            $this->mailer->isHTML(true);
            $this->mailer->send();
            echo 'Email sent successfully.';
        } catch (Exception $e) {
            echo 'Email failed to send: ' . $this->mailer->ErrorInfo;
        }
    }
}
