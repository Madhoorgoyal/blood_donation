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

$id = $_POST['id'];

// Fetch donor details
$sql = "SELECT name, email, phone, gender, age, blood_type, last_donation_date, preferred_date FROM donations WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $email, $phone, $gender, $age, $blood_type, $last_donation_date, $preferred_date);
$stmt->fetch();
$stmt->close();

// Insert deleted donor details into deleted_donors table
$sql = "INSERT INTO deleted_donors (name, email, phone, gender, age, blood_type, last_donation_date, preferred_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssisss", $name, $email, $phone, $gender, $age, $blood_type, $last_donation_date, $preferred_date);

if ($stmt->execute()) {
    // Delete donor from donations table
    $sql = "DELETE FROM donations WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Donor deleted successfully and stored in archive.'); window.top.location.href= 'admin-dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.top.location.href = 'admin-dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'admin-dashboard.php';</script>";
}

$stmt->close();
$conn->close();
?>
