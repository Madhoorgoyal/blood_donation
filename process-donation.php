<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "blood_donation";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "<script>alert('Connection failed: " . $conn->connect_error . "');</script>";
    exit();
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$blood_type = $_POST['blood-type'];
$last_donation_date = $_POST['last-donation-date'];
$preferred_date = $_POST['preferred-date'];
$message = $_POST['message'];

$sql = "INSERT INTO donations (name, email, phone, gender, age, blood_type, last_donation_date, preferred_date, message) 
        VALUES ('$name', '$email', '$phone', '$gender', '$age', '$blood_type', '$last_donation_date', '$preferred_date', '$message')";

if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Donation request submitted successfully!'); window.location.href='index.php';</script>";
    exit();
} else {
    echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location.href='index.php';</script>";
    exit();
}

mysqli_close($conn);
?>
