<nav class="navbar">
    <ul>
        <li><a href="dashboard.php" class="<?= ($seccion_activa == 'dashboard') ? 'active' : '' ?>">Inicio</a></li>
        <li><a href="docentes.php" class="<?= ($seccion_activa == 'docentes') ? 'active' : '' ?>">Docentes</a></li>
        <li><a href="alumnos.php" class="<?= ($seccion_activa == 'alumnos') ? 'active' : '' ?>">Alumnos</a></li>
        <li><a href="carreras.php" class="<?= ($seccion_activa == 'carreras') ? 'active' : '' ?>">Carreras</a></li>
        <li><a href="materias.php" class="<?= ($seccion_activa == 'materias') ? 'active' : '' ?>">Materias</a></li>
        <li><a href="perfil.php" class="<?= ($seccion_activa == 'perfil') ? 'active' : '' ?>">Ir a perfil</a></li>
        <li><a href="logout.php" class="logout">Salir</a></li>
    </ul>
    
</nav>
<div class="logo-container" style="align-items: center; justify-content: center; margin-bottom: 10px; width: 100%;">
    <img class="logo" src="../assets/img/logo_ingenierias.png" alt="Logo Ingenierías" style="height:47px; vertical-align:middle; margin-right:14px;">
</div>