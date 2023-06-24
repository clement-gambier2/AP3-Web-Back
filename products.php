<?php
include 'config.php';

// get all the products from the database
$sql = "SELECT * FROM products";
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
