<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $phone, $address);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_customers.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Customer</h2>
        <form method="post">
            <label>Name: <input type="text" name="name" required></label><br>
            <label>Email: <input type="email" name="email"></label><br>
            <label>Phone: <input type="text" name="phone"></label><br>
            <label>Address: <input type="text" name="address"></label><br>
            <input type="submit" value="Add Customer">
        </form>
        <a href="manage_customers.php">Back</a>
    </div>
</body>
</html>
