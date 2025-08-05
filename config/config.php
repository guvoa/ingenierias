<?php
session_start();

require_once('../includes/utils.php');

define('APP_NAME', 'ingenierias');

// Datos de conexión
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'kevorkian');
define('DB_NAME', 'ingenierias_db');

define('DEBUG', true); // Ponlo en false para ocultar los debug


function get_db_connection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die('Error de conexión: ' . $conn->connect_error);
    }
    return $conn;
}
?>
