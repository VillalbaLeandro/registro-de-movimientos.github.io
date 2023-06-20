<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigoCliente'];

    if (clienteExiste($codigo)) {
        echo '<h1>INFORME DE MOVIMIENTOS POR CLIENTE</h1>';
        echo '<table border="1">';
        echo '<tr><th>Cod. Cliente</th><th>Nombre y Apellido</th><th>Fecha</th><th>Nro. Factura</th><th>Importe</th></tr>';
        
        $archivoMovimientos = fopen('movimiento_clientes.txt', 'r');
        $archivoClientes = fopen('clientes.txt', 'r');
        $total = 0;
        while (!feof($archivoMovimientos)) {
            $lineaMovimientos = fgets($archivoMovimientos);
            $datosMovimientos = explode(',', $lineaMovimientos);
           
            // Verificar si el código del cliente coincide
            if ($codigo === $datosMovimientos[0]) {
                // Obtener el nombre y apellido del cliente desde el archivo 'clientes.txt'
                while (!feof($archivoClientes)) {
                    $lineaClientes = fgets($archivoClientes);
                    $datosClientes = explode(',', $lineaClientes);

                    if ($codigo === $datosClientes[0]) {
                        $nombreApellido = $datosClientes[1];
                        break;
                    }
                }

                echo '<tr>';
                echo '<td>' . $datosMovimientos[0] . '</td>';
                echo '<td>' . $nombreApellido . '</td>';
                echo '<td>' . $datosMovimientos[2] . '</td>';
                echo '<td>' . $datosMovimientos[1] . '</td>';
                echo '<td>' . $datosMovimientos[3] . '</td>';
                echo '</tr>';
                $importe = floatval($datosMovimientos[3]);
                if (is_numeric($importe)) {
                    
                    $total += $importe;
                }

            }
        }
        echo '<tr><td colspan="3" style="border:none"></td><td>TOTAL</td><td>' . $total ;

        fclose($archivoMovimientos);
        fclose($archivoClientes);

        echo '</table>';
        echo "<button><a href='index.html'>Volver al inicio</a></button>";

    } else {
        echo "<h1>El código de cliente ingresado no existe</h1>";
        echo "<button><a href='index.html'>Volver al inicio</a></button>";
    }
}
