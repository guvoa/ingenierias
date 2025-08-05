<?php
require_once __DIR__ . '/../config/config.php';

class Usuario {
    public static function autenticar($username, $password) {
        $conn = get_db_connection();
        $stmt = $conn->prepare('SELECT * FROM usuarios WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($user = $resultado->fetch_assoc()) {
            // Verifica password con hash
            if (password_verify($password, $user['password'])) {
                return $user; // Devuelve el usuario completo
            }
        }
        return false;
    }
}
?>