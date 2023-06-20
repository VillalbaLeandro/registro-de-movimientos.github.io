<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el artículo ya existe
function articuloExiste($codigo) {
    $archivo = fopen('articulos.txt', 'r');
    
    while (!feof($archivo)) {
        $linea = fgets($archivo);
        $datos = explode(',', $linea);

        // Verificar si el código del artículo coincide
        if ($codigo === $datos[0]) {
            fclose($archivo);
            return true;
        }
    }

    fclose($archivo);
    return false;
}

if (!file_exists('articulos.txt')) {
    $archivo = fopen('articulos.txt', 'w');
    fclose($archivo);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo_articulo'];
    $descripcion = $_POST['nombre_articulo'];

    if (articuloExiste($codigo)) {
        echo "<h1>No se puede dar de alta, el Código de Artículo ya existe.</h1>";
        echo "<button><a href=index.html>Volver al inicio</a></button>";
    } else {
        $operacion = $codigo . "," . $descripcion . "\n";

        $archivo = fopen('articulos.txt', 'a');
        fwrite($archivo, $operacion);
        fclose($archivo);
        echo "<h1>Artículo registrado exitosamente.</h1>";
        echo "<button><a href=index.html>Volver al inicio</a></button>";
    }
}

?>
