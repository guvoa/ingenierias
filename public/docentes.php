<?php
require_once('../middleware/auth.php');
require_once('../config/config.php');
$seccion_activa = 'docentes';

// Configuración paginación
$por_pagina = 15;
$pagina = isset($_REQUEST['pagina']) && is_numeric($_REQUEST['pagina']) && $_REQUEST['pagina'] > 0 ? (int)$_REQUEST['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

// Procesa filtros
$filtros = ['clave','nombre','apellido','tipo','correo','telefono'];
$where = [];
$params = [];
$tipos = '';
foreach ($filtros as $filtro) {
    if (!empty($_REQUEST[$filtro])) {
        $where[] = "$filtro LIKE ?";
        $params[] = '%' . $_REQUEST[$filtro] . '%';
        $tipos .= 's';
    }
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Conexión
$conn = get_db_connection();

// Conteo total
$stmt_count = $conn->prepare("SELECT COUNT(*) FROM docentes $where_sql");
if ($where) $stmt_count->bind_param($tipos, ...$params);
$stmt_count->execute();
$stmt_count->bind_result($total_registros);
$stmt_count->fetch();
$stmt_count->close();

$total_paginas = ceil($total_registros / $por_pagina);

// Consulta paginada
$sql = "SELECT * FROM docentes $where_sql ORDER BY apellido_paterno, nombre LIMIT ? OFFSET ?";
$stmt = $conn->prepare($where 
    ? "SELECT * FROM docentes $where_sql ORDER BY apellido_paterno, nombre LIMIT ? OFFSET ?"
    : "SELECT * FROM docentes ORDER BY apellido_paterno, nombre LIMIT ? OFFSET ?");
if ($where) {
    $all_params = array_merge($params, [$por_pagina, $inicio]);
    $stmt->bind_param($tipos . "ii", ...$all_params);

} else {
    $stmt->bind_param("ii", $por_pagina, $inicio);
}
$stmt->execute();
$result = $stmt->get_result();
$docentes = [];
while ($doc = $result->fetch_assoc()) {
    $docentes[] = $doc;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Docentes - Ingenierías</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
    <body>   
        <div class="docentes-layout">    
            <aside class="buscador-lateral">
                <h3>Buscar Docentes por:</h3>
                <form method="post" autocomplete="off">
                    <label for="clave">Clave</label>
                    <input type="text" id="clave" name="clave" value="<?= htmlspecialchars($_REQUEST['clave'] ?? '') ?>" autofocus>

                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($_REQUEST['nombre'] ?? '') ?>">

                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($_REQUEST['apellido'] ?? '') ?>">

                    <label for="tipo">Tipo</label>
                    <select id="tipo" name="tipo">
                        <option value="">-- Todos --</option>
                        <option value="Tiempo Completo" <?= (($_REQUEST['tipo'] ?? '') == 'Tiempo Completo') ? 'selected' : '' ?>>Tiempo Completo</option>
                        <option value="Por Asignatura" <?= (($_REQUEST['tipo'] ?? '') == 'Por Asignatura') ? 'selected' : '' ?>>Por Asignatura</option>
                    </select>

                    <label for="correo">Correo</label>
                    <input type="text" id="correo" name="correo" value="<?= htmlspecialchars($_REQUEST['correo'] ?? '') ?>">

                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($_REQUEST['telefono'] ?? '') ?>">

                    <button type="submit">Buscar</button>
                </form>
                <div class="nav-contenedor">
                    <?php include('../includes/navbar.php'); ?>
                </div>
            </aside>
            <main class="listado-docentes-main">
                <h2 style="color:#00A699;margin-bottom:20px;">Listado General de Docentes</h2>
                <div class="tabla-docentes-container">
                    <!-- <div class="paginacion">
                        <?php if ($pagina > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina-1])) ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <?php if ($i == $pagina): ?>
                                <span class="actual"><?= $i ?></span>
                            <?php else: ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if ($pagina < $total_paginas): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina+1])) ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div> -->
                    <table class="tabla-docentes">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Tipo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (count($docentes) > 0): ?>
                        <?php foreach ($docentes as $doc): ?>
                        <tr>
                            <td><?= htmlspecialchars($doc['clave']) ?></td>
                            <td><?= htmlspecialchars($doc['nombre']) ?></td>
                            <td><?= htmlspecialchars($doc['apellido_paterno']) ?></td>
                            <td><?= htmlspecialchars($doc['apellido_materno']) ?></td>
                            <td><?= htmlspecialchars($doc['tipo']) ?></td>
                            <td><?= htmlspecialchars($doc['correo']) ?></td>
                            <td><?= htmlspecialchars($doc['telefono']) ?></td>
                            <td>
                            <a href="perfil_docente.php?id=<?= htmlspecialchars($doc['id']) ?>">
                                    <img src="../assets/img/icons/profile.png" alt="Perfil" style="height:25px; vertical-align:middle; margin-right:14px; cursor: pointer;">
                                </a>
                                <a href="editar_docente.php?id=<?= htmlspecialchars($doc['id']) ?>">
                                    <img src="../assets/img/icons/edit.png" alt="Editar" style="height:25px; vertical-align:middle; margin-right:14px; cursor: pointer;">
                                </a>
                                <a href="eliminar_docente.php?id=<?= htmlspecialchars($doc['id']) ?>">
                                    <img src="../assets/img/icons/delete.png" alt="Eliminar" style="height:25px; vertical-align:middle; margin-right:14px; cursor: pointer;">
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="sin-resultados">
                            <span style="color: #A401A4; font-weight: bold; font-size: 1.1em;">No se encontraron docentes con esos criterios.</span>
                            <br><br>
                            <span style="color: #A401A4; font-weight: bold; font-size: 1.1em;">Intenta con otros criterios de búsqueda.</span>
                        </td></tr>
                    <?php endif; ?>
                    </tbody>
                    </table>
                    <div class="paginacion">
                        <?php if ($pagina > 1): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina-1])) ?>">&laquo; Anterior</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <?php if ($i == $pagina): ?>
                                <span class="actual"><?= $i ?></span>
                            <?php else: ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php if ($pagina < $total_paginas): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina+1])) ?>">Siguiente &raquo;</a>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>