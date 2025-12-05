<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_categories.php");
    exit();
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Category</h2>
        <form method="post">
            <label>Name: <input type="text" name="name" required></label>
            <label>Description: <input type="text" name="description"></label>
            <input type="submit" value="Add Category">
        </form>
        <a href="manage_categories.php">Back</a>
    </div>
</body>
</html>
