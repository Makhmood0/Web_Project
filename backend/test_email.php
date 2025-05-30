<?php
// Include PHPMailer classes
require __DIR__ . '/../mailer/PHPMailer.php';
require __DIR__ . '/../mailer/SMTP.php';
require __DIR__ . '/../mailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Create PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'roziqovjasurbe@gmail.com';     
    $mail->Password = 'gladmndvgnroctba';        
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Email content
    $mail->setFrom('youremail@gmail.com', 'LAA University');
    $mail->addAddress('slwdsoul@gmail.com');     
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = '<strong>This is a test email using PHPMailer.</strong>';

    $mail->send();
    echo "✅ Email sent successfully\n";
} catch (Exception $e) {
    echo "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
}
