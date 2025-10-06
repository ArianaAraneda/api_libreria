<!--Esta clase Bd permite conectarse a una base de datos MySQL usando PDO. 
Configura la conexión para manejar errores mediante excepciones y asegura 
que la codificación de caracteres sea UTF-8. Si falla la conexión, 
muestra un mensaje de error y detiene el script.-->
<?php
/**
 * Clase de conexión a la base de datos con PDO
 */
class Bd {
    // Datos de conexión a la base de datos
    private $host = 'localhost';          // Servidor de la base de datos (local)
    private $db_name = 'library_api';     // Nombre de la base de datos
    private $username = 'root';           // Usuario de la base de datos
    private $password = '';               // Contraseña del usuario
    public $conn;                         // Propiedad pública que guardará la conexión PDO

    // Método para conectarse a la base de datos
    public function connect(): PDO {
        $this->conn = null;               // Inicializa la conexión como null
        try {
            // Crea una nueva conexión PDO usando los datos de la clase
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}", // DSN (Data Source Name)
                $this->username,                                     // Usuario
                $this->password                                      // Contraseña
            );
            // Configura PDO para que lance excepciones en caso de error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Configura la conexión para que use UTF-8
            $this->conn->exec("set names utf8");
        } catch (PDOException $e) { // Captura errores de conexión
            echo 'Error de conexión: ' . $e->getMessage(); // Muestra el mensaje de error
            exit; // Detiene la ejecución del script si hay error
        }
        return $this->conn; // Devuelve la conexión PDO
    }
}
?>
