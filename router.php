<?php
// Autoriser l'accès depuis n'importe quelle origine
header('Access-Control-Allow-Origin: *');

// Autoriser les méthodes spécifiques à votre API (GET, POST, etc.)
header('Access-Control-Allow-Methods: GET, POST');

// Autoriser les en-têtes supplémentaires si nécessaire
header('Access-Control-Allow-Headers: Content-Type');

// Définir le type de contenu de la réponse comme JSON
header('Content-Type: application/json');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Requête POST
  $route = $_POST['route'];

  switch ($route) {
    case 'addOrder':
      include 'addOrder.php';
      break;
    case 'updateOrder':
      include 'updateOrder.php';
      break;
    case 'login':
        include 'login.php';
        break;
    // Ajoutez d'autres routes POST ici
    default:
      http_response_code(404);
      echo json_encode(['error' => 'Route not found']);
      break;
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Requête GET
  $route = $_GET['route'];

  switch ($route) {
    case 'products':
        include 'products.php';
        break;
    case 'productSelection':
      include 'productSelection.php';
      break;
    default:
      http_response_code(404);
      echo json_encode(['error' => 'Route not found']);
      break;
  }
} else {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
}
?>