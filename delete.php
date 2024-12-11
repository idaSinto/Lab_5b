<?php
include "config.php"; 

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Delete the user based on matric
if (isset($_GET['matric'])) {
    $matric = $conn->real_escape_string($_GET['matric']);

    $sql = "DELETE FROM users WHERE matric = '$matric'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully. <a href='display_users.php'>Go back to user list</a>";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

$conn->close();
?>
