<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $gender = $data["gender"];
    $firstName = $data["firstName"];
    $lastName = $data["lastName"];
    $email = $data["email"];
    $phone = $data["phone"];
    $programme = $data["programme"]; 

    $mail = new PHPMailer(true);

    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@gmail.com'; 
        $mail->Password = 'your_app_password';   
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('your_email@gmail.com', 'LAA University');
        $mail->addAddress('admin@example.com'); 
        $mail->isHTML(true);
        $mail->Subject = "New Programme Interest: $programme";
        $mail->Body = "
            <h3>New Student Interest</h3>
            <p><strong>Name:</strong> $firstName $lastName</p>
            <p><strong>Gender:</strong> $gender</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Programme:</strong> $programme</p>
        ";

        $mail->send();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
?>
