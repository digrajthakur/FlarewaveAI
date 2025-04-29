<?php
// DB connection variables
$host = "localhost"; // or your host
$username = "u117911919_leads_user";
$password = "9#Ao[tSjN";
$database = "u117911919_leads_connect";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and get POST data
$firstName = htmlspecialchars(trim($_POST['firstName']));
$lastName  = htmlspecialchars(trim($_POST['lastName']));
$email     = htmlspecialchars(trim($_POST['email']));
$message   = htmlspecialchars(trim($_POST['message']));

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO leads (first_name, last_name, email, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $firstName, $lastName, $email, $message);

// Execute and check
if ($stmt->execute()) {
    echo "Thank you! Your message has been submitted.";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>