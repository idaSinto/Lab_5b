<!DOCTYPE html>
<html>
<head>
    <title>Display Users</title>
    <link rel="stylesheet" href="styles.css">
    <!-- <style>
        table, th, td {
            border: 1px solid;
        }
    </style> -->
</head>
<body>
    <h2>Users List</h2>
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
            <th>Action</th>
        </tr>

        <?php
        include "config.php"; 

        // Fetch data from the database
        $sql = "SELECT matric, name, role FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['matric']) . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . htmlspecialchars($row['role']) . "</td>
                        <td>
                            <a href='update.php?matric=" . urlencode($row['matric']) . "'>Update</a> | 
                            <a href='delete.php?matric=" . urlencode($row['matric']) . "' 
                               onclick=\"return confirm('Are you sure you want to delete this user?');\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
