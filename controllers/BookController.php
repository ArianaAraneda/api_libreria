<!--Esta clase BookController funciona como un controlador REST para manejar libros.

Se comunica con el modelo Book para consultar, crear, actualizar o eliminar libros en la base de datos.

Utiliza Response::json() para enviar respuestas en formato JSON con el código HTTP adecuado.

Valida datos antes de crear o actualizar un libro y responde con mensajes de error si es necesario.-->
<?php
/**
 * Controlador de libros
 */

// Incluye el modelo Book, que maneja la lógica de la base de datos
require_once __DIR__ . '/../models/Book.php';
// Incluye la clase Response para enviar respuestas JSON
require_once __DIR__ . '/../utils/Response.php';

class BookController {
    private $model; // Propiedad que contendrá una instancia del modelo Book

    // Constructor de la clase
    public function __construct() {
        $this->model = new Book(); // Crea una instancia del modelo Book
    }

    // GET /books - Obtiene todos los libros
    public function getAll() {
        Response::json($this->model->getAll()); // Devuelve un JSON con todos los libros
    }

    // GET /books/{id} - Obtiene un libro por su ID
    public function get($id) {
        $book = $this->model->getById($id); // Busca el libro en la base de datos
        if (!$book) { // Si no se encuentra
            Response::json(['mensaje' => 'Libro no encontrado'], 404); // Responde con error 404
            return;
        }
        Response::json($book); // Si se encuentra, devuelve el libro en JSON
    }

    // POST /books - Crea un nuevo libro
    public function create($data) {
        // Valida que existan los campos obligatorios
        if (empty($data['titulo']) || empty($data['autor'])) {
            Response::json(['mensaje' => 'Faltan datos obligatorios'], 400); // Error 400
            return;
        }
        $anio = $data['anio'] ?? null; // Año es opcional
        // Llama al modelo para crear el libro
        $ok = $this->model->create($data['titulo'], $data['autor'], $anio);
        // Devuelve un JSON con el resultado y código HTTP (201 si se creó, 500 si hubo error)
        Response::json(['success' => $ok], $ok ? 201 : 500);
    }

    // PUT /books/{id} - Actualiza un libro existente
    public function update($id, $data) {
        $anio = $data['anio'] ?? null;           // Año opcional
        $disp = $data['disponible'] ?? 1;        // Disponibilidad por defecto 1 (disponible)
        // Llama al modelo para actualizar el libro
        $ok = $this->model->update($id, $data['titulo'], $data['autor'], $anio, $disp);
        // Devuelve un JSON con el resultado y código HTTP (200 si OK, 500 si error)
        Response::json(['success' => $ok], $ok ? 200 : 500);
    }

    // DELETE /books/{id} - Elimina un libro
    public function delete($id) {
        $ok = $this->model->delete($id); // Llama al modelo para eliminar el libro
        // Devuelve un JSON con el resultado y código HTTP (200 si OK, 500 si error)
        Response::json(['success' => $ok], $ok ? 200 : 500);
    }
}
?>
