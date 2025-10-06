<!--Este archivo funciona como front controller de la API:

Toda solicitud pasa primero por aquí.

Se encargará de cargar el sistema de enrutamiento (Routes.php) 
que determina qué controlador y método deben ejecutarse según la URL.-->

<?php
// Punto de entrada a la API
// Este archivo se ejecuta cuando se llama a la API y carga todas las rutas definidas

// Incluye el archivo de rutas, que se encarga de manejar las URLs y llamar a los 
// controladores correspondientes
require_once __DIR__ . '/../routes/Routes.php';
?>
