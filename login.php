<?php
include 'config.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email and password from the request body
    $email = $_POST['email'];
    $password = $_POST['password'];
    $loginData = json_decode(file_get_contents('php://input'), true);

    // Prepare the SQL statement to check if the user exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $loginData["email"], $loginData["password"]);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User exists
        $response = array('success' => true, 'message' => 'User exists', 'data' => $result->fetch_assoc());
        echo json_encode($response);
    } else {
        // User does not exist
        $response = array('data' => $loginData["email"] ,'success' => false, 'message' => 'User does not exist');
        echo json_encode($response);
    }
} else {
    // Request method is not POST
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}

//close connection
$conn->close();
?>
