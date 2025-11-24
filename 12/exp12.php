<?php
// --- CONFIGURATION ---
$uploadDirectory = "uploads/"; // The folder to save files into. MUST exist!
$maxFileSize = 2 * 1024 * 1024; // 2 MB in bytes
$allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

// --- VARIABLES ---
$errors = [];
$successMessage = "";

// --- FORM PROCESSING ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if a file was uploaded
    // "myFile" is the 'name' of our <input type="file">
    if (isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] == UPLOAD_ERR_OK) {
        
        // Store file details in variables for easier access
        $file = $_FILES["myFile"];
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];

        // --- 1. VALIDATE: Check for any upload errors ---
        // (This check is already done by UPLOAD_ERR_OK, but good to know)
        if ($fileError !== UPLOAD_ERR_OK) {
            $errors[] = "An error occurred during upload. Error code: " . $fileError;
        }

        // --- 2. VALIDATE: Check file size ---
        if ($fileSize > $maxFileSize) {
            $errors[] = "File is too large. Maximum size is " . ($maxFileSize / 1024 / 1024) . " MB.";
        }

        // --- 3. VALIDATE: Check file extension (type) ---
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileExtension = strtolower($fileExtension); // Convert to lowercase

        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Invalid file type. Allowed types are: " . implode(", ", $allowedExtensions);
        }

        // --- PROCESS: If no errors, move the file ---
        if (empty($errors)) {
            
            // Create a new, unique filename to prevent overwriting
            // and remove unsafe characters.
            $newFileName = uniqid() . "." . $fileExtension;
            $destination = $uploadDirectory . $newFileName;

            // move_uploaded_file() is the secure way to handle uploads
            if (move_uploaded_file($fileTmpName, $destination)) {
                $successMessage = "Success! File uploaded as: " . htmlspecialchars($newFileName);
            } else {
                $errors[] = "There was an error moving the file.";
            }
        }

    } elseif (isset($_FILES["myFile"]) && $_FILES["myFile"]["error"] == UPLOAD_ERR_NO_FILE) {
        $errors[] = "No file was selected. Please choose a file to upload.";
    } else {
        $errors[] = "An unknown error occurred.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP File Upload</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .upload-container { max-width: 500px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .message { padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .error { color: #D8000C; background-color: #FFD2D2; border: 1px solid #D8000C; }
        .success { color: #4F8A10; background-color: #DFF2BF; border: 1px solid #4F8A10; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 8px; box-sizing: border-box; }
        .submit-btn { background-color: #007BFF; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="upload-container">
        <h2>File Upload with Validation</h2>

        <?php if (!empty($successMessage)): ?>
            <div class="message success">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="message error">
                <strong>Please fix the following errors:</strong><br>
                <?php 
                foreach ($errors as $error) {
                    echo "- " . $error . "<br>";
                }
                ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="myFile">Choose a file (jpg, png, pdf - max 2MB):</label>
                <input type="file" id="myFile" name="myFile">
            </div>

            <div class="form-group">
                <input type="submit" class="submit-btn" value="Upload File">
            </div>

        </form>
    </div>

</body>
</html>