<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

// Remote database connection details
$servername = "sql12.freesqldatabase.com";
$usernameDB = "sql12722639";
$passwordDB = "paN7mzzK8i"; 
$dbname = "sql12722639";
$port = 3306; 

$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname, $port);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$user_id = $_SESSION['user_id'];
$date = date('Y-m-d'); // Get today's date

$sql = "SELECT * FROM user_food_entries WHERE user_id = ? AND date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$meals = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($meals);

$stmt->close();
$conn->close();
?>
