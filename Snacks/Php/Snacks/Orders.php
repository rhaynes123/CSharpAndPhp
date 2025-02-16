<?php
echo 'Hello';
$serverName = "127.0.0.1"; 
$database = "SnackRack";
$password = "Password1";
$dsn = "mysql:host=$serverName;dbname=$database;";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch results as an associative array
        PDO::ATTR_EMULATE_PREPARES   => false, // Use real prepared statements
    ];

    $conn = new PDO($dsn, 'root', $password, $options);


    
// Set error mode to exception
$orderStmt = $conn->prepare("SELECT * FROM `SnackRack`.`Orders` ORDER BY `Id` LIMIT 300 OFFSET 0;");
$orderStmt->execute();
$data = $orderStmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>