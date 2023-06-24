<?php
include 'config.php';


// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email and password from the request body
    $productData = json_decode(file_get_contents('php://input'), true);

    // Prepare the SQL statement to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("d", $productData["id"]);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    }
} else {
    // Request method is not POST
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}

//close connection
$conn->close();
?>

