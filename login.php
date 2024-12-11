<!DOCTYPE html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="styles.css">
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="matric">Matric</label>
        <input type="text" name="matric" required><br><br>

        <label for="password">Password</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Login"><br><br>

        <p><a href="register.php">Register</a> here if you have not.</p>
    </form>
</body>

<?php
include "config.php"; 

if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $conn->real_escape_string(trim($_POST['matric']));
    $password = $_POST['password']; // We leave the password as it is for later hashing verification

    if (!empty($matric) && !empty($password)) {
        // Query to fetch user details
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start(); // Start the session
                $_SESSION['user'] = [
                    'name' => $user['name'],
                    'role' => $user['role'], // Optional: include more details if required
                ];
                header("Location: display_users.php");
                exit;
            } else {
                echo "Invalid username or password. Try <a href='login.php'>login</a> again.";
            }
        } else {
            echo "Invalid username or password. Try <a href='login.php'>login</a> again.";
        }

        $stmt->close();
    } else {
        echo "Please fill in all required fields.";
    }
}

$conn->close();
?>
