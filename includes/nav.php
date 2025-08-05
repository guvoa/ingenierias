<nav class="navbar-top">
    <div class="navbar-container">
        <div class="navbar-logo">
            <img src="../assets/img/logo_ingenierias.png" alt="Logo Ingenierías" class="logo-img">
            <span class="logo-text">Ingenierías</span>
        </div>
        <ul class="navbar-menu">
            <li><a href="dashboard.php"      class="<?= ($seccion_activa=='dashboard')?'active':''; ?>">Inicio</a></li>
            <li><a href="docentes.php"       class="<?= ($seccion_activa=='docentes')?'active':''; ?>">Docentes</a></li>
            <li><a href="alumnos.php"        class="<?= ($seccion_activa=='alumnos')?'active':''; ?>">Alumnos</a></li>
            <li><a href="carreras.php"       class="<?= ($seccion_activa=='carreras')?'active':''; ?>">Carreras</a></li>
            <li><a href="materias.php"       class="<?= ($seccion_activa=='materias')?'active':''; ?>">Materias</a></li>
            <li><a href="perfil.php"         class="<?= ($seccion_activa=='perfil')?'active':''; ?>">Perfil</a></li>
            <li><a href="logout.php"         class="logout">Salir</a></li>
        </ul>
    </div>
</nav>