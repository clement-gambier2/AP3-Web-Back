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

// get all the products from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

// check errors
if (!$result) {
    die("Erreur d'exécution de la requête : " . $conn->error);
}
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

//close connection
$conn->close();

// Send data
echo json_encode($data);
?>
