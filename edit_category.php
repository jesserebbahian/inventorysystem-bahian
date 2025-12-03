<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE categories SET name=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_categories.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Category</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required></label><br>
            <label>Description: <input type="text" name="description" value="<?php echo htmlspecialchars($category['description']); ?>"></label><br>
            <input type="submit" value="Update Category">
        </form>
        <a href="manage_categories.php">Back</a>
    </div>
</body>
</html>
