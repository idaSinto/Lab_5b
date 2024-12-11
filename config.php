<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "lab_5b");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>