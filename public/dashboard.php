<?php
require_once('../middleware/auth.php');
$seccion_activa = 'dashboard';
include('../includes/nav.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Ingenierías</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include('../includes/navbar.php'); ?>
    <div style="padding: 30px 15px;">
        <h1>Bienvenido, <?php echo $_SESSION['nombre'] ?? $_SESSION['user']; ?>.</h1>
        <p>Este es el panel principal del sistema <strong><?php echo APP_NAME; ?></strong>.</p>
        <div style="margin-top:32px; border: 1px solid #00A699; background: #000066; padding: 18px; border-radius:10px;">
            <h3 style="color:#00A699;">Acceso rápido</h3>
            <ul>
                <li><a href="#" style="color:#00A699;">Ver docentes</a></li>
                <li><a href="#" style="color:#00A699;">Ver alumnos</a></li>
                <li><a href="#" style="color:#00A699;">Ver carreras</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
