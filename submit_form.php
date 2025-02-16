<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);
  $message = htmlspecialchars($_POST['message']);

  // Validate inputs
  if (empty($name) || empty($email) || empty($message)) {
    echo "All fields are required.";
    exit;
  }

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
  }

  // Create a new PHPMailer instance
  $mail = new PHPMailer(true);

  try {
    // Server settings for Gmail SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Gmail's SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'whayter7@gmail.com'; // Your Gmail address
    $mail->Password = 'scuf hxxy yhxx aqnq'; // Your Gmail app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port = 587; // TCP port to connect to

    // Recipients
    $mail->setFrom($email, $name); // Sender's email and name
    $mail->addAddress('whayter7@gmail.com'); // Recipient's email (your Gmail address)

    // Content
    $mail->isHTML(false); // Set email format to plain text
    $mail->Subject = "New Message from The Language Studio Website";
    $mail->Body = "Name: $name\nEmail: $email\nMessage:\n$message";

    // Send the email
    $mail->send();

    // Redirect to a thank-you page
    header("Location: thank_you.html");
    exit;
  } catch (Exception $e) {
    // Handle errors
    echo "Oops! Something went wrong. Please try again later.";
    error_log("Mailer Error: {$mail->ErrorInfo}");
  }
} else {
  echo "Invalid request.";
}
?>