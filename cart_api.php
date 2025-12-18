<?php
$host = 'localhost';
$db = 'supermarket';
$user = 'root'; 
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];

    $stmt = $conn->prepare("INSERT INTO cart (name, price, quantity, total) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdid", $name, $price, $quantity, $total);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add item to cart.']);
    }

    $stmt->close();
}

$conn->close();
?>
