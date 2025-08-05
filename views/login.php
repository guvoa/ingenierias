<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Ingenierías</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <form class="login-container" method="POST" action="../controllers/AuthController.php" autocomplete="off">
        <h2>Acceso a Ingenierías</h2>
        <label for="username">Usuario</label>
        <input type="text" name="username" id="username" autocomplete="username" required placeholder="Tu usuario">

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" autocomplete="current-password" required placeholder="Tu contraseña">

        <input type="submit" value="Entrar">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="footer-note">Presiona <b>[ESC]</b> para salir</div>
    </form>
</body>
</html>