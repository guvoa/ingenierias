<?php
// $materias debe llegar como array desde el controlador
?>
<div class="tabla-materias-container">
    <table class="tabla-materias">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Carrera</th>
                <th>Semestre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($materias) > 0): ?>
            <?php foreach ($materias as $mat): ?>
            <tr>
                <td><?= htmlspecialchars($mat['clave']) ?></td>
                <td><?= htmlspecialchars($mat['nombre']) ?></td>
                <td><?= htmlspecialchars($mat['tipo']) ?></td>
                <td><?= htmlspecialchars($mat['carrera']) ?></td>
                <td><?= htmlspecialchars($mat['semestre']) ?></td>
                <td><?= htmlspecialchars($mat['descripcion']) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="sin-resultados">No se encontraron materias.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>