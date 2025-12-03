<?php
include 'database.php';
require_once 'init_tables.php';

$customers = $conn->query("SELECT id, name, email, phone, address FROM customers");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Manage Customers</h2>
        <a href="add_customer.php" class="btn btn-primary">Add New Customer</a>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($customers && $customers->num_rows > 0) {
                    while ($row = $customers->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td>
                                <a href="edit_customer.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete_customer.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            No customers yet. <a href="add_customer.php">Add one now!</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php">Back</a>
    </div>
</body>
</html>
