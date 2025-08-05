<?php
require_once('../middleware/auth.php');
require_once('../config/config.php');
$seccion_activa = 'docentes';

// Validar parámetro
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header('Location: docentes.php');
    exit;
}

// Conexión a BD y consulta
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT * FROM docentes WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$docente = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$docente) {
    header('Location: docentes.php');
    exit;
}

// (Opcional) Si tienes foto por campo 'foto', úsala. Si no, default.
$ruta_foto = isset($docente['foto']) && $docente['foto'] 
    ? "../assets/img/usuarios/" . htmlspecialchars($docente['foto'])
    : "../assets/img/usuarios/default.png";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Perfil Docente - <?= htmlspecialchars($docente['nombre'] . " " . $docente['apellido']) ?></title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="docentes-layout">
        <aside class="buscador-lateral">
            <div class="nav-contenedor">
                <?php include('../includes/navbar.php'); ?>
            </div>

            <nav class="buscador-lateral-docente">
                <a href="perfil_docente.php?id=<?= $id ?>" class="side-link active">&rarr; Perfil</a>
                <!-- Links demo, puedes ampliar: -->
                <a href="#" class="side-link" data-section="materias" data-id="<?= $id ?>">&rarr; Materias que imparte</a>
                <a href="#" class="side-link" data-section="historial" data-id="<?= $id ?>">&rarr; Historial de clases</a>
                <a href="#" class="side-link" data-section="contacto" data-id="<?= $id ?>">&rarr; Contacto</a>
                <a href="docentes.php" class="side-link">&larr; Volver al listado</a>
            </nav>
            
        </aside>
        <!-- Área principal AJAX -->
        <main class="perfil-docente-main">
        <h2 style="color:#00A699; margin-top:0;"><?= htmlspecialchars("$nombre $apellido") ?></h2>
            <div id="contenido-docente" class="contenido-dinamico-docente">
                <!-- Aquí carga AJAX (por default el perfil) -->
            </div>
        </main>
    </div>
    <script>
        // Cargar perfil por default
        document.addEventListener("DOMContentLoaded", function() {
            cargarSeccion('perfil', <?= $id ?>);

            document.querySelectorAll('.side-link[data-section]').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    let seccion = this.dataset.section;
                    let id = this.dataset.id;
                    document.querySelectorAll('.side-link').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');
                    cargarSeccion(seccion, id);
                });
            });
        });

        function cargarSeccion(seccion, id) {
            fetch('../controllers/DocenteController.php?section=' + seccion + '&id=' + id)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('contenido-docente').innerHTML = html;
                });
        }
    </script>
    <!-- Tus scripts van aquí -->
    <script>
        window.docenteId = <?= $id ?>;
    </script>
    <script src="../assets/js/perfil_docente.js"></script>
</body>
</html>