<!--Este archivo funciona como router principal de la API.

Se encarga de:

Configurar CORS para Angular.

Leer la URL y el método HTTP.

Llamar al controlador de libros (BookController) según la ruta.

Manejar rutas dinámicas con IDs usando expresiones regulares.

Devolver un error 404 si la ruta no coincide con ninguna regla.-->


<?php
/**
 * Router principal de la API
 * Se encarga de recibir todas las solicitudes HTTP y enviarlas al controlador correspondiente
 */

// Permite que la API sea accesible desde Angular (localhost:4200)
header('Access-Control-Allow-Origin: http://localhost:4200');
// Define los métodos HTTP permitidos
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// Define los encabezados permitidos en la solicitud
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Preflight para CORS: si el navegador envía una petición OPTIONS, respondemos y terminamos
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Código 200 OK
    exit; // Termina la ejecución
}

// Incluye el controlador de libros
require_once __DIR__ . '/../controllers/BookController.php';

// Obtiene la ruta de la solicitud
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Define la ruta base de la API
$basePath = '/api_libreria/public';

// Quita la parte de la basePath de la URL para trabajar solo con la ruta relativa
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Quita la barra final si existe, si queda vacío se asigna "/"
$uri = rtrim($uri, '/') ?: '/';

// Obtiene el método HTTP de la solicitud (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// Crea una instancia del controlador de libros
$controller = new BookController();

// Enrutamiento según la URL y el método
switch (true) {
    // GET /books → devuelve todos los libros
    case $uri === '/books' && $method === 'GET':
        $controller->getAll();
        break;

    // GET /books/{id} → devuelve un libro específico
    case preg_match('/\/books\/(\d+)/', $uri, $m) && $method === 'GET':
        $controller->get($m[1]);
        break;

    // POST /books → crea un nuevo libro
    case $uri === '/books' && $method === 'POST':
        $data = json_decode(file_get_contents('php://input'), true); // Lee JSON del body
        $controller->create($data);
        break;

    // PUT /books/{id} → actualiza un libro existente
    case preg_match('/\/books\/(\d+)/', $uri, $m) && $method === 'PUT':
        $data = json_decode(file_get_contents('php://input'), true); // Lee JSON del body
        $controller->update($m[1], $data);
        break;

    // DELETE /books/{id} → elimina un libro
    case preg_match('/\/books\/(\d+)/', $uri, $m) && $method === 'DELETE':
        $controller->delete($m[1]);
        break;

    // Ruta no encontrada
    default:
        Response::json(['mensaje' => 'Ruta no encontrada', 'uri' => $uri], 404);
}
?>
