<?php
require_once('../config/config.php');
$section = $_GET['section'] ?? 'perfil';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) exit('ID inválido');

//debug($section, true);
// Según la sección, incluye la vista correspondiente (solo fragmento)
switch ($section) {
    case 'materias':
        include('../views/docente/materias.php');
        break;
    case 'historial':
        include('../views/docente/historial.php');
        break;
    case 'contacto':
        include('../views/docente/contacto.php');
        break;
    default:
        include('../views/docente/perfil.php');
}