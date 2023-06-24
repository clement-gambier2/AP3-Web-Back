<?php
include 'config.php';

$servername = "localhost"; 
$username = "clement"; 
$password = "avocadoForever";
$database = "avocado";

//connect to db
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Check if product ID is provided


// Check if update request is sent
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get the updated product data from the request body
    $updatedProduct = json_decode(file_get_contents("php://input"), true);
    $newProduct = $updatedProduct['product'];
    //Extract the relevant properties
    // $updatedName = $updatedProduct['name'];
    // $updatedPrice = $updatedProduct['price'];
    // $updatedDescription = $updatedProduct['description'];
    // $updatedPicture = $updatedProduct['picture'];
    // $updatedQuantity = $updatedProduct['quantity'];

    // Update the product in the database
    $sql = "UPDATE products SET 
        name = ?,
        price = ?,
        description = ?,
        picture = ?,
        quantity = ?
        WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sdssii",
        $newProduct['name'],
        $newProduct['price'],
        $newProduct['description'],
        $newProduct['picture'],
        $newProduct['quantity'],
        $newProduct['id']
    );

    // Execute the prepared statement
    if ($stmt->execute()) {
        // New order added successfully
        $response = array('success' => true, 'message' => $newProduct);
        echo json_encode($response);
    } else {
        // Error in executing the prepared statement
        $response = array('getValue' => $newProduct, 'success' => false, 'message' => 'Error updating product');
        echo json_encode($response);
    }
}
//close connection
$conn->close();
?>
