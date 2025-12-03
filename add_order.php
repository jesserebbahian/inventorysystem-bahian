<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $products = isset($_POST['products']) ? $_POST['products'] : array();
    
    if (empty($products)) {
        $error = "Please select at least one product.";
    } else {
        // Start transaction
        $conn->begin_transaction();
        
        try {
            // Insert order
            $sql = "INSERT INTO orders (customer_id, order_date) VALUES (?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $order_id = $conn->insert_id;
            $stmt->close();
            
            // Insert order items
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) SELECT ?, id, ?, price FROM products WHERE id=?";
            $stmt = $conn->prepare($sql);
            
            foreach ($products as $product_id) {
                $quantity = intval($_POST['quantity_' . $product_id]);
                $stmt->bind_param("iii", $order_id, $quantity, $product_id);
                $stmt->execute();
            }
            $stmt->close();
            
            // Update order total
            $sql = "UPDATE orders SET total_amount = (SELECT SUM(price * quantity) FROM order_items WHERE order_id=?) WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $order_id, $order_id);
            $stmt->execute();
            $stmt->close();
            
            $conn->commit();
            header("Location: view_orders.php");
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error = "Error creating order: " . $e->getMessage();
        }
    }
}

// Fetch customers
$customers = $conn->query("SELECT id, name FROM customers");
// Fetch products
$products_result = $conn->query("SELECT id, name, price FROM products");

$error = isset($error) ? $error : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Create Order</h2>
        
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        
        <form method="post">
            <label>Customer:
                <select name="customer_id" required>
                    <option value="">-- Select a customer --</option>
                    <?php if ($customers && $customers->num_rows > 0) {
                        while ($customer = $customers->fetch_assoc()) { ?>
                            <option value="<?php echo $customer['id']; ?>"><?php echo htmlspecialchars($customer['name']); ?></option>
                        <?php }
                    } ?>
                </select>
            </label>
            
            <h3>Products</h3>
            <table border="1">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products_result && $products_result->num_rows > 0) {
                        while ($product = $products_result->fetch_assoc()) { ?>
                            <tr>
                                <td><input type="checkbox" name="products[]" value="<?php echo $product['id']; ?>"></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td><input type="number" name="quantity_<?php echo $product['id']; ?>" min="1" value="1"></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px;">
                                No products available. <a href="add_product.php">Add products first!</a>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 20px;">
                                No products available. <a href="add_product.php">Add one now!</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <input type="submit" value="Create Order">
        </form>
        <a href="view_orders.php">Back</a>
    </div>
</body>
</html>
