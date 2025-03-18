<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO donations (name, email, phone, gender, age, blood_type, last_donation_date, preferred_date, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssissss", $name, $email, $phone, $gender, $age, $blood_type, $last_donation_date, $preferred_date, $message);

// Set parameters and execute
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$blood_type = $_POST['blood-type'];
$last_donation_date = $_POST['last-donation-date'];
$preferred_date = $_POST['preferred-date'];
$message = $_POST['message'];

if ($stmt->execute()) {
    echo "<script>alert('Donor added successfully');  window.top.location.href = 'admin-dashboard.php';</script>";
	 
} else {
    echo "<script>alert('Error: " . $stmt->error . "');  window.top.location.href = 'admin-dashboard.php';</script>";
	
}

$stmt->close();
$conn->close();
?>
