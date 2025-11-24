<?php
session_start();

// Unset all of the session variables
session_unset();

// Destroy the session
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session - Page 3</title>
</head>
<body>

    <h1>Session Destroyed</h1>
    <p>All session data has been removed.</p>

    <a href="exp13(3).php">Go back to the View Page</a>

</body>
</html>