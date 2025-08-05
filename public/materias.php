<?php
require_once('../middleware/auth.php');
require_once('../controllers/MateriaController.php');
$seccion_activa = 'materias';
$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$por_pagina = 15;
$data = MateriaController::getMateriasPaginadas($pagina, $por_pagina);
$materias = $data['materias'];
$total_paginas = ceil($data['total'] / $por_pagina);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Materias - Ingenierías</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>


<div class="materias-layout">
    
    <aside class="buscador-lateral">
        <h3>Buscar:</h3>
        <form id="form-filtro-materias" onsubmit="return false;">
            <label for="carrera_id">Carrera</label>
            <select id="carrera_id" name="carrera_id" onchange="filtrarMaterias()">
                <option value="">-- Todas --</option>
                <?php foreach($carreras as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="semestre_id">Semestre</label>
            <select id="semestre_id" name="semestre_id" onchange="filtrarMaterias()">
                <option value="">-- Todos --</option>
                <?php foreach($semestres as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Para más filtros, agrega aquí -->
        </form>
        <div class="nav-contenedor">
            <?php include('../includes/navbar.php'); ?>
        </div>
    </aside>
                    
    <main class="listado-materias-main">
        <h2 style="color:#00A699;margin-bottom:20px;">Listado General de Materias</h2>
        <?php include('../views/materia/listado.php'); ?>

        <div class="paginacion">
            <?php if ($pagina > 1): ?>
                <a href="?pagina=<?= $pagina-1 ?>">&laquo; Anterior</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <?php if ($i == $pagina): ?>
                    <span class="actual"><?= $i ?></span>
                <?php else: ?>
                    <a href="?pagina=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($pagina < $total_paginas): ?>
                <a href="?pagina=<?= $pagina+1 ?>">Siguiente &rarr;</a>
            <?php endif; ?>
        </div>
    </main>
</div>
</body>
</html>