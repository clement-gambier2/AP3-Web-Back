<?php
include 'config.php';

// Récupérer les données du corps de la requête
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données sont valides
if (!isset($data['product']['name']) || !isset($data['product']['price']) || !isset($data['product']['description']) || !isset($data['product']['picture']) || !isset($data['product']['quantity'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid data']);
  exit;
}

// Informations de connexion à la base de données
$servername = "localhost";
$username = "clement";
$password = "avocadoForever";
$database = "avocado";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier si la connexion a réussi
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(['error' => 'Database connection failed']);
  exit;
}

// Préparer les données pour l'insertion dans la base de données (échapper les caractères spéciaux si nécessaire)
$name = $conn->real_escape_string($data['product']['name']);
$price = $conn->real_escape_string($data['product']['price']);
$description = $conn->real_escape_string($data['product']['description']);
$picture = $conn->real_escape_string($data['product']['picture']);
$quantity = $conn->real_escape_string($data['product']['quantity']);

// Créer la requête SQL d'insertion
$sql = "INSERT INTO products (name, price, description, picture, quantity) VALUES ('$name', '$price', '$description', '$picture', '$quantity')";

// Exécuter la requête SQL
if ($conn->query($sql) === TRUE) {
  // Récupérer l'ID du produit nouvellement inséré
  $productId = $conn->insert_id;

  // Répondre avec les données du produit ajouté
  $newProduct = [
    'id' => $productId,
    'name' => $name,
    'price' => $price,
    'description' => $description,
    'picture' => $picture,
    'quantity' => $quantity
  ];

  echo json_encode(['success' => true, 'product' => $newProduct]);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to insert product']);
}

// Fermer la connexion à la base de données
$conn->close();
?>
