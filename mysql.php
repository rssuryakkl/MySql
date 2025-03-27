<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// Database Connection
$conn = new mysqli("localhost", "root", "", "your_database");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Get POST Data
$names = $_POST['names'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$gender = $_POST['gender'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

if (!$names || !$email || !$phone || !$gender || !$password) {
    die(json_encode(["error" => "All fields are required"]));
}

// Insert into Database
$sql = "INSERT INTO users (names, email, phone, gender, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $names, $email, $phone, $gender, $password);

if ($stmt->execute()) {
    echo json_encode(["success" => "User registered successfully"]);
} else {
    echo json_encode(["error" => "Registration failed"]);
}

$stmt->close();
$conn->close();
?>
