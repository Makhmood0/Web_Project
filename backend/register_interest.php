<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';
require '../mailer/Exception.php';
require '../backend/db.php';

$raw = file_get_contents("php://input");
if (!$raw) {
    echo json_encode(["success" => false, "message" => "No input received"]);
    exit;
}
$data = json_decode($raw, true);
if (!$data) {
    echo json_encode(["success" => false, "message" => "JSON decode error", "raw" => $raw]);
    exit;
}

$gender = $data['gender'];
$first_name = $data['first_name'];
$last_name = $data['last_name'];
$email = $data['email'];
$phone = $data['phone'];
$programme_id = $data['programme_id'];


$stmt = $pdo->prepare("SELECT title FROM programmes WHERE id = ?");
$stmt->execute([$programme_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$programme_name = $row ? $row['title'] : "Unknown Programme";

try {
    
    $stmt = $pdo->prepare("INSERT INTO interests (gender, first_name, last_name, email, phone, programme_id, programme_name)
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$gender, $first_name, $last_name, $email, $phone, $programme_id, $programme_name]);

   
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'roziqovjasurbe@gmail.com';
    $mail->Password = 'gladmndvgnroctba';         
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('roziqovjasurbe@gmail.com', 'LAA University');
    $mail->addAddress($email, "$first_name $last_name");
    $mail->isHTML(true);
    $mail->Subject = '🎓 Welcome to LAA University!';
    $mail->Body = "
        <h2>Dear $first_name $last_name,</h2>
        <p>Thank you for registering your interest in the <strong>$programme_name</strong> programme.</p>
        <p>We’re excited to have you explore your future at LAA University!</p>
        <br>
        <strong>We'll be in touch with more information soon.</strong><br><br>
        Regards,<br>LAA University Admissions Team";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
