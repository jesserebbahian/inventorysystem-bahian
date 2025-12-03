<?php
include 'database.php';
require_once 'init_tables.php';

// Now fetch products with categories
$sql = "SELECT p.id, p.name, p.price, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id";
$result = $conn->query($sql);

$error_msg = null;
if (!$result) {
    $error_msg = "Database error: " . $conn->error;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Products</h2>
        
        <div>
            <a href="add_product.php" class="btn btn-primary">Add Product</a>
            <a href="manage_categories.php" class="btn btn-primary">Manage Categories</a>
            <a href="manage_customers.php" class="btn btn-primary">Manage Customers</a>
            <a href="view_orders.php" class="btn btn-primary">View Orders</a>
        </div>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            No products yet. <a href="add_product.php">Add one now!</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
