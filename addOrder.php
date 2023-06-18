<?php
//config
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
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

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order data from the request body
    $orderData = json_decode(file_get_contents('php://input'), true);

    // Prepare the SQL statement to insert the new order
    $sql = "INSERT INTO orders (totalPrice) VALUES (?)";
    $stmt = $conn->prepare($sql);

    // Bind the parameter to the prepared statement
    $stmt->bind_param("d", $orderData); // Utilisation de "d" pour le type de données décimal

    // Execute the prepared statement
    if ($stmt->execute()) {
        // New order added successfully
        $response = array('success' => true, 'message' => 'Order added successfully');
        echo json_encode($response);
    } else {
        // Error in executing the prepared statement
        $response = array('getValue' => $orderData, 'success' => false, 'message' => 'Error adding order');
        echo json_encode($response);
    }
} else {
    // Request method is not POST
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}

// Close connection
$conn->close();
?>
