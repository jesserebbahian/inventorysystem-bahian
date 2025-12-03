<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "UPDATE customers SET name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_customers.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM customers WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Customer</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
            <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required></label><br>
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>"></label><br>
            <label>Phone: <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>"></label><br>
            <label>Address: <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>"></label><br>
            <input type="submit" value="Update Customer">
        </form>
        <a href="manage_customers.php">Back</a>
    </div>
</body>
</html>
