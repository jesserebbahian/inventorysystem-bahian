<?php
include 'database.php';
require_once 'init_tables.php';

$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
header("Location: index.php");
exit();
?>
