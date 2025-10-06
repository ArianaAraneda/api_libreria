<!--La clase Book es un modelo que hereda de Model, por lo que ya tiene la conexión a la 
base de datos lista en $this->db.

Cada método corresponde a una operación CRUD sobre la tabla books:

getAll() → leer todos los libros.

getById($id) → leer un libro específico.

create(...) → insertar un nuevo libro.

update(...) → actualizar un libro existente. 

delete($id) → eliminar un libro. 


<?php
/**
 * Modelo Book: gestiona operaciones con la tabla books
 */

// Incluye la clase base Model para tener la conexión a la base de datos
require_once __DIR__ . '/../core/Model.php';

class Book extends Model {

    // Obtiene todos los libros de la tabla books
    public function getAll() {
        $stmt = $this->db->query("SELECT id, titulo, autor, anio, disponible FROM books"); // Ejecuta la consulta
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los resultados como array asociativo
    }

    // Obtiene un libro específico por su ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT id, titulo, autor, anio, disponible FROM books WHERE id = ?"); // Preparar consulta con placeholder
        $stmt->execute([$id]); // Ejecuta la consulta pasando el ID
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve el resultado como array asociativo
    }

    // Crea un nuevo libro
    public function create($titulo, $autor, $anio) {
        $stmt = $this->db->prepare("INSERT INTO books (titulo, autor, anio, disponible) VALUES (?, ?, ?, 1)"); // Query de inserción
        return $stmt->execute([$titulo, $autor, $anio]); // Ejecuta la inserción con los valores y devuelve true/false
    }

    // Actualiza un libro existente
    public function update($id, $titulo, $autor, $anio, $disp) {
        $stmt = $this->db->prepare("UPDATE books SET titulo=?, autor=?, anio=?, disponible=? WHERE id=?"); // Query de actualización
        return $stmt->execute([$titulo, $autor, $anio, (int)$disp, $id]); // Ejecuta la actualización y devuelve true/false
    }

    // Elimina un libro por su ID
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id=?"); // Query de eliminación
        return $stmt->execute([$id]); // Ejecuta la eliminación y devuelve true/false
    }
}
?>
