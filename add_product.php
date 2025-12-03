<?php
include 'database.php';

// Initialize tables
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $sql = "INSERT INTO products (name, price, category_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdi", $name, $price, $category_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

// Fetch categories for dropdown
$categories = $conn->query("SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="post">
            <label>Name: <input type="text" name="name" required></label>
            <label>Price: <input type="number" name="price" step="0.01" required></label>
            <label>Category:
                <select name="category_id" required>
                    <option value="">-- Select a category --</option>
                    <?php while ($cat = $categories->fetch_assoc()) { ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="submit" value="Add Product">
        </form>
        <a href="index.php">Back</a>
    </div>
</body>
</html>
