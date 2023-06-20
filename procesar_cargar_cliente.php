<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//comprobar que si el cliente existe. Si no existe lo crea
function clienteExiste($codigo) {
    $archivo = fopen('clientes.txt', 'r');
    
    while (!feof($archivo)) {
        $linea = fgets($archivo);
        $datos = explode(',', $linea);

        // Verificar si el código del cliente coincide
        if ($codigo === $datos[0]) {
            fclose($archivo);
            return true;
        }
    }

    fclose($archivo);
    return false;
}

if (!file_exists('clientes.txt')) {
    $archivo = fopen('clientes.txt', 'w');
    fclose($archivo);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nombreYApellido = $_POST['nombre'];

    if (clienteExiste($codigo)) {
        echo "<h1>No se puede dar de alta, Codigo de Cliente ya existe.</h1>";
        echo "<button><a href=index.html>volver al inicio.</a><button>";

    } else {
        $operacion = $codigo . "," . $nombreYApellido . "\n";

        $archivo = fopen('clientes.txt', 'a');
        fwrite($archivo, $operacion);
        fclose($archivo);
        echo "<h1>Cliente registrado exitosamente.</h1>";
        echo "<button><a href=index.html>volver al inicio.</a><button>";
    }
}



?>