<?php
require_once('../middleware/auth.php');
$seccion_activa = 'perfil';
require_once('../config/config.php');
require_once('../includes/utils.php');


// Función auxiliar para actualizar perfil
function actualizarPerfil($conn, $username) {
    $mensaje = '';
    $nombre = trim($_POST['nombre'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $foto = $_FILES['foto'] ?? null;

    // Actualiza nombre
    if ($nombre !== '') {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ? WHERE username = ?");
        $stmt->bind_param('ss', $nombre, $username);
        $stmt->execute();
        $_SESSION['nombre'] = $nombre;
        $mensaje .= "Nombre actualizado. ";
    }

    // Actualiza contraseña si se captura
    if ($password !== '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET password = ? WHERE username = ?");
        $stmt->bind_param('ss', $hash, $username);
        $stmt->execute();
        $mensaje .= "Contraseña actualizada. ";
    }

    // Sube foto si se carga
    if ($foto && $foto['size'] > 0) {
        $ext = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $destino = "../assets/img/usuarios/" . $username . "." . $ext;
            if (move_uploaded_file($foto['tmp_name'], $destino)) {
                $foto_bd = $username . "." . $ext;
                $stmt = $conn->prepare("UPDATE usuarios SET foto = ? WHERE username = ?");
                $stmt->bind_param('ss', $foto_bd, $username);
                $stmt->execute();
                $_SESSION['foto'] = $foto_bd;
                $mensaje .= "Foto de perfil actualizada. ";
            } else {
                $mensaje .= "Error al subir la foto. ";
            }
        } else {
            $mensaje .= "Formato de foto no permitido. ";
        }
    }

    return $mensaje;
}

// Al actualizar perfil
$conn = get_db_connection();
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensaje = actualizarPerfil($conn, $_SESSION['user']);
}

// Consulta usuario actual (por si hay cambios recientes)
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
$stmt->bind_param('s', $_SESSION['user']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$_SESSION['nombre'] = $user['nombre'];
$_SESSION['foto'] = $user['foto'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mi perfil - Ingenierías</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <?php include('../includes/navbar.php'); ?>
    <div class="perfil-container">
        <h2>Mi perfil</h2>
        <div class="perfil-card">
            <img src="<?=
                isset($user['foto']) && $user['foto']
                ? '../assets/img/usuarios/' . htmlspecialchars($user['foto'])
                : '../assets/img/usuarios/default.png'
            ?>" alt="Foto de perfil">
            <div><b>Usuario:</b> <?= htmlspecialchars($user['username']); ?></div>
            <div><b>Nombre:</b> <?= htmlspecialchars($user['nombre']); ?></div>
        </div>
        <form class="perfil-form" method="POST" enctype="multipart/form-data">
            <label for="nombre">Editar nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($user['nombre']); ?>" maxlength="100">

            <label for="password">Cambiar contraseña</label>
            <input type="password" name="password" id="password" placeholder="Nueva contraseña (opcional)">

            <label for="foto">Cambiar foto de perfil (JPG, PNG)</label>
            <input type="file" name="foto" id="foto" accept=".jpg,.jpeg,.png">

            <input type="submit" value="Guardar cambios">
        </form>
        <?php if ($mensaje): ?>
            <div class="perfil-mensaje"><?= htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        <div style="margin-top:18px; text-align:center;">
            <a href="dashboard.php" style="color:#00A699;">&larr; Volver al dashboard</a>
        </div>
    </div>
</body>
</html>