<?php
//config
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$servername = "localhost"; 
$username = "clement"; 
$password = "avocadoForever";
$database = "avocado";

//connect to db
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Check if product ID is provided
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // get the product from the database
    $sql = "SELECT * FROM products WHERE id = '$productId'";
    $result = $conn->query($sql);

    // check errors
    if (!$result) {
        die("Erreur d'exécution de la requête : " . $conn->error);
    }

    $product = $result->fetch_assoc();

    // Send product data
    echo json_encode($product);
} 
//close connection
$conn->close();
?>
