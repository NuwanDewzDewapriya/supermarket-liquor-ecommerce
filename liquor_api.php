<?php
$servername = "localhost"; 
$username = "root"; 
$password = "";
$dbname = "supermarket"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
      
        $sql = "SELECT * FROM liquors";
        $result = $conn->query($sql);
        $liquors = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $liquors[] = $row;
            }
        }
        echo json_encode($liquors);
        break;

    case 'POST':
     
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $total = $price * $quantity;
        
        $sql = "INSERT INTO liquors (name, price, quantity, total) VALUES ('$name', '$price', '$quantity', '$total')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Liquor added successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
        break;

    case 'PUT':
       
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = $_PUT['id'];
        $name = $_PUT['name'];
        $price = $_PUT['price'];
        $quantity = $_PUT['quantity'];
        $total = $price * $quantity;

        $sql = "UPDATE liquors SET name='$name', price='$price', quantity='$quantity', total='$total' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Liquor updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
        break;

    case 'DELETE':
       
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = $_DELETE['id'];
        
        $sql = "DELETE FROM liquors WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "Liquor deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $conn->error]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Invalid request method."]);
        break;
}

$conn->close();
?>
