<?php
// mail.php

// Form POST ile gelmemişse çık
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

// Form verilerini al
$firstName   = $_POST['contact-name'] ?? '';
$lastName    = $_POST['contact-lastname'] ?? '';
$email       = $_POST['contact-email'] ?? '';
$phone       = $_POST['contact-phone'] ?? '';
$subject     = $_POST['subject'] ?? 'New Contact Message';
$messageText = $_POST['contact-message'] ?? '';

// Temel validation
if (!$firstName || !$lastName || !$email || !$phone || !$messageText) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Kendine gelecek mail adresi
$to = "support@castready.org"; // ← BURAYA kendi mail adresini yaz

// Mail başlığı
$subjectFull = "Contact Form: " . $subject;

// Mesaj içeriği
$message = "
New message from your website contact form:

Name: $firstName $lastName
Email: $email
Phone: $phone
Subject: $subject

Message:
$messageText
";

// Header'lar
$headers = "From: $firstName $lastName <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Mail gönder
if (mail($to, $subjectFull, $message, $headers)) {
    echo json_encode(["status" => "success", "message" => "Message sent successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Mail could not be sent."]);
}
?>
