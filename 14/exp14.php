<?php
include("database.php");

// --- 1. HANDLE FORM SUBMISSION (INSERT) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username)) {
        echo "Please enter a username.<br>";
    } elseif (empty($password)) {
        echo "Please enter a password.<br>";
    } else {
        // Hash the password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB
        $sql_insert = "INSERT INTO users (user, password) VALUES ('$username', '$hash')";
        
        try {
            mysqli_query($conn, $sql_insert);
            echo "<div style='color:green'>You are now registered!</div>";
        } catch (mysqli_sql_exception $e) {
            echo "<div style='color:red'>Error registering user: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fakebook Registration</title>
  <style>
      table { border-collapse: collapse; width: 50%; margin-top: 20px; }
      th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
      th { background-color: #f2f2f2; }
  </style>
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Welcome to Fakebook</h1>
        <label>Username:</label><br>
        <input type="text" name="username"><br>
        
        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <input type="submit" name="submit" value="Register">
    </form>

    <hr>

    <h2>Registered Users</h2>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Hashed Password</th> </tr>

        <?php
        // --- 2. FETCH AND DISPLAY DATA (SELECT) ---
        
        $sql_fetch = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql_fetch);

        // Check if there are rows in the database
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row and display it
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                // Note: Change 'id' to whatever your primary key column is named (e.g., 'user_id')
                // If you don't have an ID column, remove this line.
                echo "<td>" . (isset($row['id']) ? $row['id'] : 'N/A') . "</td>"; 
                echo "<td>" . $row['User'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users registered yet.</td></tr>";
        }
        ?>
    </table>

</body>
</html>

<?php
// Close the connection at the very end of the file
mysqli_close($conn);
?>