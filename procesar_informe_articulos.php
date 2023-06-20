<?php
// Obtener el código del artículo ingresado en el formulario
$codigo_articulo = $_POST['codigo_articulo'];

// Leer el archivo de artículos y buscar la descripción del artículo
$articulos = file('articulos.txt', FILE_IGNORE_NEW_LINES);
$descripcion_articulo = '';
foreach ($articulos as $articulo) {
    $datos_articulo = explode(',', $articulo);
    if ($datos_articulo[0] === $codigo_articulo) {
        $descripcion_articulo = $datos_articulo[1];
        break;
    }
}

// Leer el archivo de movimientos de clientes y buscar los movimientos del artículo
$movimientos = file('movimiento_clientes.txt', FILE_IGNORE_NEW_LINES);
$informe_movimientos = [];

foreach ($movimientos as $movimiento) {
    $datos_movimiento = explode(',', $movimiento);
    $codigo_cliente = $datos_movimiento[0];
    $nro_factura = $datos_movimiento[1];
    $fecha = $datos_movimiento[2];
    $importe = $datos_movimiento[3];

    // Buscar el nombre y apellido del cliente en el archivo de clientes
    $clientes = file('clientes.txt', FILE_IGNORE_NEW_LINES);
    $nombre_cliente = '';
    foreach ($clientes as $cliente) {
        $datos_cliente = explode(',', $cliente);
        if ($datos_cliente[0] === $codigo_cliente) {
            $nombre_cliente = $datos_cliente[1];
            break;
        }
    }

    // Verificar si el movimiento corresponde al código del artículo ingresado
    if ($datos_movimiento[4] === $codigo_articulo) {
        $informe_movimientos[] = [
            'codigo_cliente' => $codigo_cliente,
            'nombre_cliente' => $nombre_cliente,
            'nro_factura' => $nro_factura,
            'fecha' => $fecha,
            'importe' => $importe
        ];
    }
}

// Generar el informe de movimientos por artículo
echo '<h2><center>Informe por Artículos</center></h2>';
echo 'Cód. Artículo: ' . $codigo_articulo . ' Desc. Artículo: ' . $descripcion_articulo . '<br><br>';
echo '<table border=1>';
echo '<tr><th>Cód. Cli.</th><th>Nombre y Apellido</th><th>Nro. De Factura</th><th>Fecha</th><th>Importe</th></tr>';

$total = 0;

foreach ($informe_movimientos as $movimiento) {
    echo '<tr>';
    echo '<td>' . $movimiento['codigo_cliente'] . '</td>';
    echo '<td>' . $movimiento['nombre_cliente'] . '</td>';
    echo '<td>' . $movimiento['nro_factura'] . '</td>';
    echo '<td>' . $movimiento['fecha'] . '</td>';
    echo '<td>' . $movimiento['importe'] . '</td>';
    echo '</tr>';

    $total += $movimiento['importe'];
}

echo '<tr><td colspan="4">TOTAL</td><td>' . $total . '</td></tr>';
echo '</table>';
?>
