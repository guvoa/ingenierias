<?php
require_once __DIR__ . '/../models/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $user = Usuario::autenticar($username, $password);

    if ($user) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['nombre'] = $user['nombre'];
        header("Location: ../public/dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../public/index.php");
        exit;
    }
} else {
    header("Location: ../public/index.php");
    exit;
}
