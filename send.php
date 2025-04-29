<?php
$host = "localhost";
$username = "u117911919_leads_user";
$password = "9#Ao[tSjN";
$database = "u117911919_leads_connect";

// Create connection
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
    echo "Thank you! Your message has been submitted.";
} else {
    http_response_code(500);
    echo "Error saving your message.";
}


$stmt->close();
$conn->close();
?>