<!--Esta clase Model sirve como clase base para todos los modelos de la aplicación.

Cada modelo (por ejemplo Book) heredará de esta clase y tendrá automáticamente la conexión a 
la base de datos lista para usar.

La propiedad $db contiene el objeto PDO que permite ejecutar consultas SQL de manera segura.-->

<?php
/**
 * Clase base para todos los modelos
 * Cada modelo heredará de esta clase
 */

// Incluye la clase de conexión a la base de datos
require_once __DIR__ . '/../config/Bd.php';

class Model {
    protected $db; // Propiedad protegida que almacenará la conexión PDO

    // Constructor de la clase
    public function __construct() {
        $database = new Bd();        // Crea una instancia de la clase de conexión
        $this->db = $database->connect(); // Establece la conexión y la guarda en $db
    }
}
?>
