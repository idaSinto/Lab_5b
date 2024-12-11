<!DOCTYPE html>
<html>
    <head>
        <title>Registration Form</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <h2>Registration</h2>
        <form method="post" action="register.php">
            <label for="matric">Matric</label>
            <input type="text" name="matric" required><br><br>

            <label for="name">Name</label>
            <input type="text" name="name" required><br><br>

            <label for="password">Password</label>
            <input type="password" name="password" required><br><br>

            <label for="role">Role</label>
            <select name="role" required>
                <option value="" disabled selected>Please select</option>
                <option value="Student">Student</option>
                <option value="Lecturer">Lecturer</option>
            </select><br><br>

            <input type="submit" name="submit" value="Submit">
        </form>
    </body>
</html>

<?php 
include "config.php"; 

if (!$conn) {
    die("Database connection failed.");
}
    
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $matric = mysqli_real_escape_string($conn, $_POST['matric']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Insert data into users table
    $sql = "INSERT INTO users (matric, name, password, role) 
            VALUES ('$matric', '$name', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "User registration inserted successfully";
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>