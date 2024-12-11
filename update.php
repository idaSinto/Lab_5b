<?php
include "config.php";

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$matric = $name = $role = "";

if (isset($_GET['matric'])) {
    $matric = mysqli_real_escape_string($conn, $_GET['matric']);

    $sql = "SELECT * FROM `users` WHERE `matric` = '$matric'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $name = $user['name'];
        $role = $user['role'];
    } else {
        echo "No user found with the given Matric.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = mysqli_real_escape_string($conn, $_POST['matric']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "UPDATE `users` 
            SET `name` = '$name', `role` = '$role' 
            WHERE `matric` = '$matric'";

    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            header("Location: display_users.php");
        } else {
            echo "No changes were made.";
        }
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Update User</h2>
    <form method="post" action="update.php">
        <label for="matric">Matric</label>
        <input type="text" name="matric" value="<?php echo htmlspecialchars($matric, ENT_QUOTES); ?>" readonly><br><br>

        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" required><br><br>

        <label for="role">Access Level</label>
        <select name="role" required>
            <option value="" disabled>Please select</option>
            <option value="Student" <?php echo $role == 'student' ? 'selected' : ''; ?>>Student</option>
            <option value="Lecturer" <?php echo $role == 'lecturer' ? 'selected' : ''; ?>>Lecturer</option>
        </select><br><br>

        <input type="submit" name="submit" value="Update" class="button">
        <a href="display_users.php">Cancel</a>
    </form>
</body>
</html>
