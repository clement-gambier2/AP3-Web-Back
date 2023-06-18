<?php
//config
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: http://127.0.0.1:5173');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

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
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Check if update request is sent
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // Get the updated product data from the request body
        $updatedProduct = json_decode(file_get_contents("php://input"), true);

        // Extract the relevant properties
        $updatedName = $updatedProduct['name'];
        $updatedPrice = $updatedProduct['price'];
        $updatedDescription = $updatedProduct['description'];
        $updatedPicture = $updatedProduct['picture'];
        $updatedQuantity = $updatedProduct['quantity'];

        // Update the product in the database
        $sql = "UPDATE products SET 
            name = '$updatedName',
            price = '$updatedPrice',
            description = '$updatedDescription',
            picture = '$updatedPicture',
            quantity = '$updatedQuantity'
            WHERE id = '$productId'";

        $result = $conn->query($sql);

        // Check for errors
        if (!$result) {
            die("Erreur d'exécution de la requête : " . $conn->error);
        }

        // Return success message
        echo json_encode(['message' => 'Product updated successfully']);
    } else {
        // Get the product from the database
        $sql = "SELECT * FROM products WHERE id = '$productId'";
        $result = $conn->query($sql);

        // Check errors
        if (!$result) {
            die("Erreur d'exécution de la requête : " . $conn->error);
        }

        $product = $result->fetch_assoc();

        // Send product data
        echo json_encode($product);
    }
}

//close connection
$conn->close();
?>
