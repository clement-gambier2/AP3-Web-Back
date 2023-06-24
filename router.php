<?php
// Autoriser l'accès depuis n'importe quelle origine
header('Access-Control-Allow-Origin: *');

// Autoriser les méthodes spécifiques à votre API (GET, POST, etc.)
header('Access-Control-Allow-Methods: GET, POST, PUT');

header('Access-Control-Allow-Headers: Content-Type');

// Définir le type de contenu de la réponse comme JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $routerData = json_decode(file_get_contents('php://input'), true);
    switch($routerData['route']) {
        case 'addProduct':
            include 'addProduct.php';
            break;
        case 'login':
            include 'login.php';
            break;
        case 'uniqueProduct':
            include 'uniqueProduct.php';
            break;
        case 'addOrder':
            include 'addOrder.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Route not found', 'route' => $routerData['route']]);
            break;
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $routerData = $_GET['route'];
    switch($routerData) {
        case 'productSelection':
            include 'productSelection.php';
            break;
        case 'products':
            include 'products.php';
            break;
        case 'orders':
            include 'orders.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Route not found', 'route' => $routerData]);
            break;
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $routerData = json_decode(file_get_contents('php://input'), true);
    switch($routerData['route']) {
        case 'updateProduct':
            include 'updateProduct.php';
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Route not found', 'route' => $routerData['route']]);
            break;
    }
}


?>
