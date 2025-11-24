<?php
include("db.php");

// --- FETCH DATA TO PRE-FILL FORM ---
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM employees WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $employee = mysqli_fetch_assoc($result);
}

// --- UPDATE DATA IN DATABASE ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_SPECIAL_CHARS);
    $salary = filter_input(INPUT_POST, "salary", FILTER_SANITIZE_NUMBER_INT);

    $update_sql = "UPDATE employees SET name='$name', position='$position', salary='$salary' WHERE id='$id'";

    try {
        mysqli_query($conn, $update_sql);
        header("Location: index.php"); // Go back to main page
        exit;
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #e9ecef; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 350px; }
        label { display: block; margin: 15px 0 5px; font-weight: bold; color: #555; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-save { background-color: #f39c12; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; margin-top: 20px; cursor: pointer; font-size: 16px; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #7f8c8d; text-decoration: none; }
    </style>
</head>
<body>

<div class="card">
    <h2>Edit Employee</h2>
    
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">

        <label>Full Name</label>
        <input type="text" name="name" value="<?php echo $employee['name']; ?>" required>

        <label>Position</label>
        <input type="text" name="position" value="<?php echo $employee['position']; ?>" required>

        <label>Salary ($)</label>
        <input type="number" name="salary" value="<?php echo $employee['salary']; ?>" required>

        <input type="submit" class="btn-save" value="Save Changes">
        <a href="index.php" class="btn-cancel">Cancel</a>
    </form>
</div>

</body>
</html>