<?php

$host = 'localhost';
$db = 'supermarket';
$user = 'root'; 
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

$cartItems = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}


header('Content-Type: application/json');
echo json_encode($cartItems);

$conn->close();
?>
