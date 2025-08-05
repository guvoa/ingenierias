<?php
function obtenerFotoUsuario($usuario)
{
    $directorio = '../assets/img/usuarios/';
    $foto = isset($usuario['foto']) && $usuario['foto'] 
        ? $usuario['foto'] 
        : 'default.png';

    // Si no existe el archivo, regresa el default
    if (!file_exists($directorio . $foto)) {
        $foto = 'default.png';
    }

    return $directorio . $foto;
}

/**
 * Imprime cualquier variable de manera legible solo en modo desarrollo.
 * Ejemplo de uso: debug($variable);
 */
function debug($var, $exit = false) {
    if (defined('DEBUG') && DEBUG) {
        echo '<pre style="background:#1a0033;color:#00A699;border:1px solid #00A699;padding:12px 18px;font-size:1em;line-height:1.4em;border-radius:8px;z-index:9999;">';
        print_r($var);
        echo '</pre>';
        if ($exit) exit;
    }
}


?>