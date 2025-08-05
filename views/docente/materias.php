<?php debug($id, true);
// Aquí suponemos una tabla materias_docente con docente_id, materia, grupo, periodo...
$conn = get_db_connection();
$stmt = $conn->prepare("SELECT materia, grupo, periodo FROM materias_docente WHERE docente_id=? ORDER BY periodo DESC");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
?>
<h3 style="color:#00A699;">Materias que imparte</h3>
<table style="width:100%; border-collapse:collapse; background:#000066;">
    <thead>
        <tr>
            <th>Materia</th>
            <th>Grupo</th>
            <th>Periodo</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($mat = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($mat['materia']) ?></td>
            <td><?= htmlspecialchars($mat['grupo']) ?></td>
            <td><?= htmlspecialchars($mat['periodo']) ?></td>
        </tr>
        <?php endwhile; ?>
        <?php if ($result->num_rows == 0): ?>
        <tr><td colspan="3" style="color:#A401A4; text-align:center;">Este docente no tiene materias asignadas.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<?php $stmt->close(); $conn->close(); ?>