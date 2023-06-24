<?php
include 'config.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order data from the request body
    $orderData = json_decode(file_get_contents('php://input'), true);

    $sql = "INSERT INTO orders (totalPrice) VALUES (?)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("d", $orderData["total"]); // Utilisation de "d" pour le type de données décimal

    // Execute the prepared statement
    if ($stmt->execute()) {
        // New order added successfully
        $response = array('success' => true, 'message' => $orderData);
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
