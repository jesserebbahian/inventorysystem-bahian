<?php
include 'database.php';
require_once 'init_tables.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_categories.php");
    exit();
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Manage Categories</h2>
        <form method="post">
            <label>Name: <input type="text" name="name" required></label>
            <label>Description: <input type="text" name="description"></label>
            <input type="submit" value="Add Category">
        </form>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($categories && $categories->num_rows > 0) { 
                    while ($row = $categories->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>
                                <a href="edit_category.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete_category.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">
                            No categories yet.
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php">Back</a>
    </div>
</body>
</html>
