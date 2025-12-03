<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];

    $sql = "UPDATE products SET name=?, price=?, category_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdii", $name, $price, $category_id, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
$categories = $conn->query("SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Product</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required></label>
            <label>Price: <input type="number" name="price" value="<?php echo $product['price']; ?>" step="0.01" required></label>
            <label>Category:
                <select name="category_id" required>
                    <?php while ($cat = $categories->fetch_assoc()) { ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $product['category_id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php } ?>
                </select>
            </label>
            <input type="submit" value="Update Product">
        </form>
        <a href="index.php">Back</a>
    </div>
</body>
</html>
