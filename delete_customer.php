<?php
include 'database.php';
require_once 'init_tables.php';

$id = $_GET['id'];
$sql = "DELETE FROM customers WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
header("Location: manage_customers.php");
exit();
?>
