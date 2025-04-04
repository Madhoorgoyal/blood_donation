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

// Delete the request
$sql = "DELETE FROM requests WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('Request deleted successfully'); window.top.location.href = 'admin-dashboard.php';</script>";
} else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.top.location.href = 'admin-dashboard.php';</script>";
}

$stmt->close();
$conn->close();
?>
