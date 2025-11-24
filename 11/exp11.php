<?php
// Define variables and initialize with empty values
$name = $email = $phone = $password = "";
$errors = [];

// Define regular expressions
$nameRegex    = "/^[a-zA-Z-' ]*$/";
// A common, practical regex for email. Not 100% RFC compliant, but good for most cases.
// This is the corrected line:
$emailRegex   = "/^[\w.-]+@([\w-]+\.)+[\w-]{2,4}$/";
// Simple 10-digit US-style phone number (e.g., 1234567890)
$phoneRegex   = "/^\d{10}$/"; 
// Password: minimum 8 characters, at least one letter and one number
$passwordRegex = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";

// --- FORM PROCESSING ---
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 1. Validate Name ---
    if (empty(trim($_POST["name"]))) {
        $errors['name'] = "Name is required.";
    } elseif (!preg_match($nameRegex, $_POST["name"])) {
        $errors['name'] = "Only letters, spaces, hyphens, and apostrophes are allowed.";
    } else {
        $name = trim($_POST["name"]);
    }

    // --- 2. Validate Email ---
    if (empty(trim($_POST["email"]))) {
        $errors['email'] = "Email is required.";
    } elseif (!preg_match($emailRegex, $_POST["email"])) {
        $errors['email'] = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    // --- 3. Validate Phone ---
    if (empty(trim($_POST["phone"]))) {
        $errors['phone'] = "Phone number is required.";
    } elseif (!preg_match($phoneRegex, $_POST["phone"])) {
        $errors['phone'] = "Please enter a valid 10-digit phone number (e.g., 1234567890).";
    } else {
        $phone = trim($_POST["phone"]);
    }

    // --- 4. Validate Password ---
    if (empty(trim($_POST["password"]))) {
        $errors['password'] = "Password is required.";
    } elseif (!preg_match($passwordRegex, $_POST["password"])) {
        $errors['password'] = "Password must be at least 8 characters long and contain at least one letter and one number.";
    } else {
        // Note: Don't re-assign the password to a variable you'll display!
        // For security, you'd typically hash it here.
         $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    // --- CHECK FOR ERRORS ---
    if (empty($errors)) {
        // No errors! Process the data.
        // For a real app, you would insert into a database, send an email, etc.
        $successMessage = "Success! Your registration is complete.";
        
        // Clear form values after successful submission
        $name = $email = $phone = $password = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Regex Validation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box; /* Important for padding to not affect width */
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: #D8000C; /* Red */
            font-size: 0.9em;
            margin-top: 5px;
        }
        .success {
            color: #4F8A10; /* Green */
            background-color: #DFF2BF;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #4F8A10;
            margin-bottom: 20px;
        }
        .submit-btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Registration Form</h2>
        <p>Please fill out this form with valid information.</p>

        <?php 
        // Display success message if it exists
        if (!empty($successMessage)) {
            echo "<div class='success'>$successMessage</div>";
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <?php if (!empty($errors['name'])) echo "<div class='error'>" . $errors['name'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (!empty($errors['email'])) echo "<div class='error'>" . $errors['email'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="phone">Phone (10 digits):</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                <?php if (!empty($errors['phone'])) echo "<div class='error'>" . $errors['phone'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="">
                <?php if (!empty($errors['password'])) echo "<div class='error'>" . $errors['password'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <input type="submit" class="submit-btn" value="Submit">
            </div>
        </form>
    </div>

</body>
</html>