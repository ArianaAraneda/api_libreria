<!--La clase Response centraliza la forma en que la API envía respuestas JSON.

Permite definir el código HTTP fácilmente (200, 201, 400, 404, 500, etc.).

Garantiza que los caracteres especiales (acentos, ñ, etc.) se muestren 
correctamente usando JSON_UNESCAPED_UNICODE.

Se usa en los controladores para enviar respuestas al cliente Angular.-->
<?php
/**
 * Helper para devolver respuestas JSON
 * Se usa en los controladores para enviar datos al cliente de forma consistente
 */
class Response {

    // Método estático para enviar JSON con código HTTP opcional (por defecto 200)
    public static function json($data, int $status = 200) {
        http_response_code($status); // Establece el código de respuesta HTTP
        header('Content-Type: application/json; charset=utf-8'); // Indica que la respuesta es JSON UTF-8
        echo json_encode($data, JSON_UNESCAPED_UNICODE); // Convierte el array o objeto a JSON y lo imprime
    }
}
?>
