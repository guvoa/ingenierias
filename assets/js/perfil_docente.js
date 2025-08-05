// (Solo si prefieres tener el código JS fuera)
document.addEventListener("DOMContentLoaded", function() {
    cargarSeccion('perfil', window.docenteId);

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
    const contenedor = document.getElementById('contenido-docente');
    // Muestra el loader
    contenedor.innerHTML = '<div class="loader-center"><img src="../assets/img/loading.gif" alt="Cargando..."><div style="color:#00A699;margin-top:8px;">Cargando...</div></div>';
    
    let responded = false;
    // Si en 10 segundos no responde, muestra error
    const errorTimeout = setTimeout(function(){
        if (!responded) {
            contenedor.innerHTML = '<div style="color:#A401A4;text-align:center;margin:38px;font-size:1.18em;">Ha sucedido un problema. Por favor, intenta nuevamente.</div>';
        }
    }, 10000);

    // Hacemos fetch
    setTimeout(() => { // Delay de 2 segundos para ver el loader (opcional, solo para UX)
        fetch('../controllers/DocenteController.php?section=' + seccion + '&id=' + id)
            .then(response => {
                responded = true;
                clearTimeout(errorTimeout);
                if (!response.ok) throw new Error('Network error');
                return response.text();
            })
            .then(html => {
                contenedor.innerHTML = html;
            })
            .catch(() => {
                contenedor.innerHTML = '<div style="color:#A401A4;text-align:center;margin:38px;font-size:1.18em;">Ha sucedido un problema. Por favor, intenta nuevamente.</div>';
            });
    }, 2000);
}