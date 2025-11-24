<!-- CREATE DATABASE employee_db;
USE employee_db;

CREATE TABLE employees (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    salary INT(11) NOT NULL,
    PRIMARY KEY (id)
); -->

<?php
include("db.php");

// --- INSERT NEW EMPLOYEE ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $position = filter_input(INPUT_POST, "position", FILTER_SANITIZE_SPECIAL_CHARS);
    $salary = filter_input(INPUT_POST, "salary", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($name) && !empty($position)) {
        $sql = "INSERT INTO employees (name, position, salary) VALUES ('$name', '$position', '$salary')";
        mysqli_query($conn, $sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Employee Manager</title>
  <style>
      body { font-family: 'Segoe UI', sans-serif; padding: 20px; background-color: #f4f6f9; }
      .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
      
      table { width: 100%; border-collapse: collapse; margin-top: 20px; }
      th { background-color: #2c3e50; color: white; padding: 12px; text-align: left; }
      td { border-bottom: 1px solid #ddd; padding: 12px; }
      
      .btn-edit {
          background-color: #3498db; color: white; padding: 6px 12px;
          text-decoration: none; border-radius: 4px; font-size: 14px;
      }
      .btn-edit:hover { background-color: #2980b9; }

      input[type="text"], input[type="number"] { padding: 8px; width: 30%; margin-right: 10px; border: 1px solid #ccc; border-radius: 4px; }
      input[type="submit"] { padding: 8px 20px; background-color: #27ae60; color: white; border: none; cursor: pointer; border-radius: 4px; }
  </style>
</head>
<body>

<div class="container">
    <h2>HR Management System</h2>

    <div style="background: #ecf0f1; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <h3>Add New Hire</h3>
        <form action="index.php" method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="position" placeholder="Job Title" required>
            <input type="number" name="salary" placeholder="Salary" required>
            <input type="submit" value="Add Employee">
        </form>
    </div>

    <h3>Current Employees</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Position</th>
            <th>Salary</th>
            <th>Actions</th>
        </tr>

        <?php
        $sql = "SELECT * FROM employees";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td><strong>" . $row['name'] . "</strong></td>";
                echo "<td>" . $row['position'] . "</td>";
                echo "<td>$" . number_format($row['salary']) . "</td>";
                echo "<td><a href='edit.php?id=" . $row['id'] . "' class='btn-edit'>Edit Details</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No employees found.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>