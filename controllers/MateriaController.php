<?php
require_once('../config/config.php');

class MateriaController
{
    public static function getMateriasPaginadas($pagina = 1, $por_pagina = 15) {
        $conn = get_db_connection();
        $inicio = ($pagina - 1) * $por_pagina;

        // Traer nombre de carrera y semestre con JOIN
        $sql = "SELECT m.id, m.clave, m.nombre, m.tipo, m.descripcion,
                       c.nombre AS carrera, s.nombre AS semestre
                FROM materias m
                JOIN carreras c ON m.carrera_id = c.id
                JOIN semestres s ON m.semestre_id = s.id
                ORDER BY m.clave
                LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $por_pagina, $inicio);
        $stmt->execute();
        $result = $stmt->get_result();
        $materias = [];
        while ($mat = $result->fetch_assoc()) {
            $materias[] = $mat;
        }
        $stmt->close();

        $total = $conn->query("SELECT COUNT(*) AS total FROM materias")->fetch_assoc()['total'];
        $conn->close();
        return ['materias' => $materias, 'total' => $total];
    }
}
?>