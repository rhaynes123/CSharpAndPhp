<?php
//echo 'Hello';
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
$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id = max(0, $id);

switch(true){
    case ($id):
        $stmt = $conn->prepare("SELECT * FROM `SnackRack`.`Snacks` WHERE `Id` LIKE :id ORDER BY `Id` LIMIT 300 OFFSET 0");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        break;
    case (!empty($name)):
        $name = htmlspecialchars($name);
        $stmt = $conn->prepare("SELECT * FROM `SnackRack`.`Snacks` WHERE `name` LIKE :name ORDER BY `Id` LIMIT 300 OFFSET 0");
        $searchName = "%$name%"; // Add wildcard for partial match
        $stmt->bindParam(':name', $searchName, PDO::PARAM_STR);
        break;
    default:
        $stmt = $conn->prepare("SELECT * FROM `SnackRack`.`Snacks` ORDER BY `Id` LIMIT 300 OFFSET 0");
        break;
}

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data);
?>