<?php
// You must start the session on every page that uses it!
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session - Page 2</title>
</head>
<body>

    <h1>View Session</h1>
    
    <?php
    // Check if the username session variable is set
    if (isset($_SESSION["username"])) {
        echo "<p>Welcome back, " . $_SESSION["username"] . "!</p>";
        echo "<p>Age " . $_SESSION["age"] . ".</p>";
    } else {
        echo "<p>No session found or session has been destroyed.</p>";
        echo "<p>Please go to the 'set' page first.</p>";
    }
    ?>

    <a href="exp13(2).php">Go to Set Page</a><br>
    <a href="session_destroy.php">Go to Destroy Page</a>

</body>
</html>