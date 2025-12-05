<?php
// Database initialization - called by all pages to ensure tables exist

if (!isset($conn) || $conn->connect_error) {
    error_log("Connection not available in init_tables.php");
    return;
}

// Check if categories table exists
$check = $conn->query("SHOW TABLES LIKE 'categories'");
if ($check && $check->num_rows == 0) {
    // Tables don't exist - create them
    $sql_statements = array(
        "CREATE TABLE categories (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            description TEXT
        )",
        "CREATE TABLE products (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            category_id INT NOT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        )",
        "CREATE TABLE customers (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100),
            phone VARCHAR(20),
            address VARCHAR(255)
        )",
        "CREATE TABLE orders (
            id INT PRIMARY KEY AUTO_INCREMENT,
            customer_id INT NOT NULL,
            order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
            total_amount DECIMAL(10, 2),
            FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
        )",
        "CREATE TABLE order_items (
            id INT PRIMARY KEY AUTO_INCREMENT,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT DEFAULT 1,
            price DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )"
    );
    
    foreach ($sql_statements as $sql) {
        if (!$conn->query($sql)) {
            error_log("Error creating table: " . $conn->error);
        }
    }
}

// Check if products table has category_id column (for legacy database migration)
$check_column = $conn->query("SHOW COLUMNS FROM products LIKE 'category_id'");
if ($check_column && $check_column->num_rows == 0) {
    // Column doesn't exist - add it
    $conn->query("ALTER TABLE products ADD COLUMN category_id INT NOT NULL DEFAULT 1 AFTER price");
    $conn->query("ALTER TABLE products ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE");
}

// Check if customers table has all required columns
$check_phone = $conn->query("SHOW COLUMNS FROM customers LIKE 'phone'");
if ($check_phone && $check_phone->num_rows == 0) {
    // Phone column doesn't exist - add it
    $conn->query("ALTER TABLE customers ADD COLUMN phone VARCHAR(20) AFTER email");
}

$check_address = $conn->query("SHOW COLUMNS FROM customers LIKE 'address'");
if ($check_address && $check_address->num_rows == 0) {
    // Address column doesn't exist - add it
    $conn->query("ALTER TABLE customers ADD COLUMN address VARCHAR(255) AFTER phone");
}
?>
