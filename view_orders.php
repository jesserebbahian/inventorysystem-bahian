<?php
include 'database.php';
require_once 'init_tables.php';

$sql = "SELECT o.id, c.name as customer_name, COUNT(oi.id) as total_items FROM orders o JOIN customers c ON o.customer_id = c.id LEFT JOIN order_items oi ON o.id = oi.order_id GROUP BY o.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Orders</h2>
        <a href="add_order.php" class="btn btn-primary">Create New Order</a>
        <table border="1">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total Items</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo $row['total_items']; ?></td>
                            <td><a href="order_details.php?id=<?php echo $row['id']; ?>">View Details</a></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">
                            No orders yet. <a href="add_order.php">Create one now!</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php">Back</a>
    </div>
</body>
</html>
