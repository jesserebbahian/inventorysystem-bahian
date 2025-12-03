<?php
include 'database.php';
require_once 'init_tables.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT o.id, c.name as customer_name, o.order_date FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conn->prepare("SELECT oi.id, p.name as product_name, p.price, oi.quantity FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Order #<?php echo $order['id']; ?></h2>
        <p><strong>Customer:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
        <p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
        <table border="1">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="view_orders.php">Back</a>
    </div>
</body>
</html>
