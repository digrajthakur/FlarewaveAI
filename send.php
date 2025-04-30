<?php
// ✅ Use your secret key here (NOT the site key)
$secretKey = "6LfZNikrAAAAAFOG6d34M0xLPe6h6I5ZZTERWAGl"; // replace this with your real secret key

$responseKey = $_POST['g-recaptcha-response'];
$userIP = $_SERVER['REMOTE_ADDR'];

// Verify token with Google
$verifyURL = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
$captchaResponse = file_get_contents($verifyURL);
$responseData = json_decode($captchaResponse);

// CAPTCHA check failed
if (!$responseData->success) {
    http_response_code(400);
    echo "Captcha verification failed. Please check the box and try again.";
    exit;
}

// Continue with database actions below
$host = "localhost";
$username = "u117911919_leads_user";
$password = "9#Ao[tSjN";
$database = "u117911919_leads_connect";


$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed.";
    exit;
}


$firstName = htmlspecialchars(trim($_POST['firstName']));
$lastName = htmlspecialchars(trim($_POST['lastName']));
$email = htmlspecialchars(trim($_POST['email']));
$message = htmlspecialchars(trim($_POST['message']));

$stmt = $conn->prepare("INSERT INTO leads (first_name, last_name, email, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $email, $message);


if ($stmt->execute()) {
    echo "Thank you for reaching out! Your message has been successfully submitted.";
} else {
    http_response_code(500);
    echo "Error saving your message.";
}


$stmt->close();
$conn->close();
?>