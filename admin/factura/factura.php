<?php 
include '../config/APP.php';
$subtotal = 0;
$iva = 0;
$impuesto = 0;
$tl_sniva = 0;
$total = 0;

// Verifica si la configuración está disponible
if ($result_config > 0) {
    $iva = $configuracion['empresaIva'];
    $moneda = $configuracion['empresaMoneda'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Factura</title>
    <link rel="stylesheet" href="<?php echo SERVERURL . 'factura/style_factura.css'; ?>" />
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        header, main { margin: 0 auto; width: 90%; }
        #logo img { width: 80px; }
        .empresa { display: flex; justify-content: space-between; margin-top: 10px; }
        .emp_razon h2 { font-size: 20px; margin: 0; }
        .emp_razon, .empresa_cont { font-size: 12px; }
        #details { margin-top: 20px; display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        table th, table td { padding: 8px; text-align: center; border: 1px solid #ddd; }
        tfoot td { font-weight: bold; }
        #thanks { margin-top: 20px; text-align: center; font-size: 14px; }
        #invoice-info div { margin: 5px 0; font-size: 12px; }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="<?php echo SERVERURL . $configuracion['empresaFotoUrl']; ?>">
    </div>
    <div class="empresa" id="company">
        <div class="emp_razon">
            <h2 class="name"><?php echo strtoupper($configuracion['empresaNombre']); ?></h2>
            <div>R.U.C: <?php echo $configuracion['rif']; ?></div>
            <div><?php echo $configuracion['empresaDireccion']; ?></div>
        </div>
        <div class="empresa_cont">
            <div>Teléfono: <?php echo $configuracion['empresaTelefono']; ?></div>
            <div><a href="mailto:<?php echo $configuracion['empresaCorreo']; ?>"><?php echo $configuracion['empresaCorreo']; ?></a></div>
        </div>
    </div>
    <div class="document-title">
        <h1>FACTURA ELECTRÓNICA</h1>
        <div>N° <?php echo mainModel::generar_numero_factura($factura['idVenta']); ?></div>
    </div>
</header>

<main>
    <div id="details" class="clearfix">
        <div id="client">
            <div class="to">CLIENTE:</div>
            <h2 class="name"><?php echo $factura['clienteNombre'] . " " . $factura['clienteApellido']; ?></h2>
            <div class="address">DNI: <?php echo $factura['clienteDniCedula']; ?></div>
            <div class="address">Dirección: <?php echo $factura['clienteDomicilio']; ?></div>
            <div class="address">Teléfono: <?php echo $factura['clienteTelefono']; ?></div>
        </div>
        <div id="invoice">
            <div class="date">Fecha de Emisión: <?php echo $factura['fecha']; ?></div>
            <div class="date">Vendedor: <?php echo $factura['vendedor']; ?></div>
        </div>
    </div>

    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="no" width="40px">#</th>
                <th class="desc">Descripción</th>
                <th class="unit">Cantidad</th>
                <th class="qty" width="150px">Precio Unitario</th>
                <th class="total" width="150px">Precio Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $contador = 0;
        if ($result_detalle > 0) {
            while ($row = $query_productos->fetch()) {
                $contador++;
                ?>
                <tr>
                    <td class="no"><?php echo $contador; ?></td>
                    <td class="desc"><?php echo $row['prodserviNombre']; ?></td>
                    <td class="unit"><?php echo $row['detalleCantidad']; ?></td>
                    <td class="qty"><?php echo number_format($row['precio_venta'], 2, '.', ','); ?></td>
                    <td class="total"><?php echo number_format($row['precio_total'], 2, '.', ','); ?></td>
                </tr>
                <?php
                $precio_total = $row['precio_total'];
                $subtotal = round($subtotal + $precio_total, 2);
            }
        }

        $impuesto = round($subtotal * ($iva / 100), 2);
        $tl_sniva = round($subtotal - $impuesto, 2);
        $total = round($tl_sniva + $impuesto, 2);
        ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="3"></td>
            <td>Subtotal</td>
            <td><?php echo number_format($tl_sniva, 2, '.', ',') . " " . $moneda; ?></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>IGV (<?php echo $iva; ?>%)</td>
            <td><?php echo number_format($impuesto, 2, '.', ',') . " " . $moneda; ?></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>Total</td>
            <td><?php echo number_format($total, 2, '.', ',') . " " . $moneda; ?></td>
        </tr>
        </tfoot>
    </table>

    <section id="invoice-info">
        <div>
            <span>Método de Pago: </span> <span><?php echo $factura['ventMetodoPago']; ?></span>
        </div>
    </section>
    <div id="thanks">¡Gracias por su compra!</div>
</main>
</body>
</html>
