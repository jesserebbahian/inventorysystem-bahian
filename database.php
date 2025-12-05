<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bahian_db";

// Suppress warnings for cleaner error display
$conn = @new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    $error_msg = $conn->connect_error;
    
    // Determine what the issue is
    $mysql_running = @fsockopen("localhost", 3306, $errno, $errstr, 2);
    $mysql_status = $mysql_running ? "Running" : "NOT RUNNING";
    if ($mysql_running) fclose($mysql_running);
    
    die("<!DOCTYPE html>
    <html>
    <head>
        <title>Database Error</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f5f5f5; padding: 20px; }
            .container { max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            h1 { color: #d32f2f; border-bottom: 3px solid #d32f2f; padding-bottom: 10px; }
            .status { padding: 15px; margin: 15px 0; border-radius: 4px; border-left: 4px solid #d32f2f; background: #ffebee; }
            .solution { background: #e8f5e9; border-left: 4px solid #388e3c; padding: 15px; margin: 15px 0; border-radius: 4px; }
            .solution h3 { color: #388e3c; margin-top: 0; }
            ol { margin: 10px 0; padding-left: 20px; }
            li { margin: 8px 0; }
            code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
            .error-detail { background: #fff3cd; border-left: 4px solid #ffc107; padding: 10px; margin: 10px 0; border-radius: 4px; font-family: monospace; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>⚠️ Database Connection Error</h1>
            
            <div class='status'>
                <strong>MySQL Status:</strong> $mysql_status<br>
                <strong>Error:</strong> $error_msg
            </div>
            
            <div class='solution'>
                <h3>✓ How to Fix This:</h3>
                <ol>
                    <li><strong>Start MySQL:</strong>
                        <ul>
                            <li>Open XAMPP Control Panel</li>
                            <li>Click <code>Start</code> next to MySQL</li>
                            <li>Wait for green indicator</li>
                        </ul>
                    </li>
                    <li><strong>Create Database:</strong>
                        <ul>
                            <li>Visit <code>http://localhost/phpmyadmin</code></li>
                            <li>Click <code>New</code></li>
                            <li>Enter database name: <code>bahian_db</code></li>
                            <li>Click <code>Create</code></li>
                        </ul>
                    </li>
                    <li><strong>Refresh This Page:</strong>
                        <ul>
                            <li>Press <code>F5</code> or click the refresh button</li>
                            <li>Application will auto-initialize</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
            <div class='error-detail'>
                <strong>Technical Details:</strong><br>
                Server: $servername<br>
                Username: $username<br>
                Database: $dbname<br>
                Error: $error_msg
            </div>
        </div>
    </body>
    </html>");
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");
?>
