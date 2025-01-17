<?php
include '../config/APP.php';
$medidaTicket = 180;
$subtotal   = 0;
$iva        = 0;
$impuesto   = 0;
$tl_sniva   = 0;
$total      = 0;
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Boleta</title>
    <link rel="stylesheet" href="<?php echo SERVERURL . 'factura/style_ticket.css'; ?>">
    <style>
        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
            margin: auto; /* Centra la boleta */
            font-family: Arial, sans-serif; /* Fuente más moderna */
        }
        table {
            width: 100%; /* Ocupa el 100% del contenedor */
            border-collapse: collapse; /* Quita el espacio entre celdas */
            margin-top: 10px; /* Espaciado superior */
            background-color: #f9f9f9; /* Color de fondo suave */
        }
        th, td {
            padding: 8px; /* Espaciado interno */
            text-align: left; /* Alineación a la izquierda */
            border-bottom: 1px solid #ddd; /* Línea inferior sutil */
        }
        th {
            background-color: #4CAF50; /* Color de fondo de los encabezados */
            color: white; /* Color del texto en los encabezados */
            font-weight: bold; /* Negrita para los títulos de la tabla */
        }
        tr:hover {
            background-color: #f1f1f1; /* Color de fondo al pasar el mouse */
        }
        .centrado {
            text-align: center; /* Centra el texto */
        }
        .borde_bot {
            border-bottom: 2px solid #4CAF50; /* Línea en la parte inferior */
        }
        .left {
            text-align: left; /* Alineación a la izquierda */
        }
        .detalles {
            font-size: 0.9em; /* Tamaño de fuente más pequeño */
        }
        .tabletitle {
            font-weight: bold; /* Negrita para los títulos de la tabla */
        }
    </style>
</head>

<body>
    <div class="ticket">
        <?php
        if($result_config > 0){
            $iva = $configuracion['empresaIva'];
            $moneda = $configuracion['empresaMoneda'];
        ?>
        <div class="centrado">
            <h1><?php echo $configuracion['empresaNombre']; ?></h1>
            <p>RIF: <?php echo $configuracion['rif']; ?></p>
            <p><?php echo $configuracion['empresaDireccion']; ?></p>
            <p class="left">Fecha: <?php echo $factura['fecha']." ".$factura['hora']; ?></p>
            <p class="left"><strong>Factura: <?php echo mainModel::generar_numero_factura($factura['idVenta']); ?></strong></p>
        </div>
        <div class="left borde_bot">
            <p>---------------- Cliente ---------------</p>
            <p>Nombre: <strong class="detalles"><?php echo $factura['clienteNombre']." ".$factura['clienteApellido']; ?></strong></p>
            <p>DNI: <?php echo $factura['clienteDniCedula']; ?></p>
            <p>Dirección: <?php echo $factura['clienteDomicilio']; ?></p>
        </div>
        <p class="centrado"><strong>BOLETA</strong></p>
        <?php
            }
         ?>

        <table>
            <thead>
                <tr class="centrado tabletitle">
                    <th width="10%">Cant.</th>
                    <th>Descripción</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if($result_detalle > 0){
                        while ($row = $query_productos->fetch()){
                ?>
                <tr class="detalles">
                    <td class="itemtext"><?php echo $row['detalleCantidad']; ?></td>
                    <td class="itemtext"><?php echo $row['prodserviNombre']; ?> X P.U <?php echo number_format($row['precio_venta'],2,'.',',')." ".$moneda; ?></td>
                    <td class="itemtext"><?php echo number_format($row['precio_total'],2,'.',',')." ".$moneda; ?></td>
                </tr>
                <?php
                            $precio_total = $row['precio_total'];
                            $subtotal = round($subtotal + $precio_total, 2);
                        }
                    }

                    $impuesto   = round($subtotal * ($iva / 100), 2);
                    $tl_sniva   = round($subtotal - $impuesto, 2);
                    $total      = round($tl_sniva + $impuesto, 2);
                ?>
            </tbody>
            <tfoot>
                <tr class="tabletitle">
                    <td colspan="2">SUBTOTAL:</td>
                    <td class=""><?php echo number_format($tl_sniva,2,'.',',')." ".$moneda; ?></td>
                </tr>
                <tr class="tabletitle">
                    <td>IVA:</td>
                    <td><?php echo $iva." %"; ?></td>
                    <td class=""><?php echo number_format($impuesto,2,'.',',')." ".$moneda; ?></td>
                </tr>
                <tr class="tabletitle">
                    <td colspan="2"><strong>TOTAL:</strong></td>
                    <td class=""><strong><?php echo number_format($total,2,'.',',')." ".$moneda; ?></strong></td>
                </tr> 
            </tfoot>
        </table>
        <div class="borde_bot"></div>
        <p class="left">Vendedor: <?php echo $factura['vendedor']; ?></p>
        <p class="centrado">¡Gracias por su compra!</p>
    </div>
</body>

</html>
