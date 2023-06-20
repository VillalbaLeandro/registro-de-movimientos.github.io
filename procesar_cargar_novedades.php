<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//comprobar si la factura no existe

function facturaExiste($numFactura) {
    $archivo = fopen('movimiento_clientes.txt', 'r');
    
    while (!feof($archivo)) {
        $linea = fgets($archivo);
        $datos = explode(',', $linea);

        // Verificar si el código del cliente coincide
      
        if ($numFactura == $datos[1]) {
            fclose($archivo);
            return true;
        }
    }

    fclose($archivo);
    return false;
}

//comprobar que si el cliente existe para crear el registro
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


if (!file_exists('movimiento_clientes.txt')) {
    $archivo = fopen('movimiento_clientes.txt', 'w');
    fclose($archivo);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $codigo = $_POST['codigo'];
    $numFactura = $_POST['nro_factura'];
    $fecha = $_POST['fecha'];
    $importe = $_POST['importe'];
    $codArticulo = $_POST['codigo_articulo'];
    if (facturaExiste($numFactura)) {
        echo "<h2>No se puede crear el registro porque el número de factura ya existe</h2>";
        echo "<button><a href=index.html>volver al inicio.</a><button>";

    } elseif (!clienteExiste($codigo)) {
        echo "<h2>No se puede crear el registro porque el código de cliente no existe</h2>";
        echo "<button><a href=index.html>volver al inicio.</a><button>";

    } else {
        $operacion = $codigo . "," . $numFactura . "," . $fecha . "," . $importe . "," . $codArticulo . "\n";
    
        $archivo = fopen('movimiento_clientes.txt', "a");
        fwrite($archivo, $operacion);
        fclose($archivo);
        echo "<h1>Movimiento cargado correctamente</h1>";
        echo "<button><a href=index.html>volver al inicio.</a><button>";

    }

}




?>