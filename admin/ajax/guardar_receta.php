<?php
$peticionAjax=true;
require_once '../pdf/vendor/autoload.php';

use Dompdf\Dompdf;

require_once "../config/APP.php";
require_once "../controladores/recetaControlador.php";
    $receta = new recetaControlador();
if (!empty($_POST['medicamento'])) {   

    if (isset($_POST['medicamento'])) {
        echo $receta->agregar_controlador();
    }

    
}

if (isset($_GET['generarReporte'])) {
    if (empty($_GET['generarReporte'])) {
        echo 'Error';
        exit;
    }

    $respuesta = $receta->getReceta($_GET['generarReporte']);
    $medicamento = $respuesta['medicamento'];
    $dosis = $respuesta['dosis'];
    $instrucciones = $respuesta['instrucciones'];
    $mascota = $respuesta['mascotaNombre'];

    // Generar el PDF con DomPDF
    $dompdf = new Dompdf();
    $html = "
<html>
<head>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }
    .ticket {
        max-width: 400px;
        margin: auto;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border: 1px solid #007bff;
    }
    .header {
        text-align: center;
        font-size: 24px;
        margin-bottom: 15px;
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }
    .section {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .section h3 {
        margin: 0;
        margin-right: 10px;
        color: #333;
        font-size: 18px;
        font-weight: bold;
    }
    .content {
        font-size: 16px;
        color: #555;
    }
    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #777;
    }
</style>
</head>
<body>
<div class='ticket'>
    <div class='header'>Receta Médica</div>
    <div class='section'>
        <h3>Mascota:</h3>
        <div class='content'>$mascota</div>
    </div>
    <div class='section'>
        <h3>Medicamento:</h3>
        <div class='content'>$medicamento</div>
    </div>
    <div class='section'>
        <h3>Dosis:</h3>
        <div class='content'>$dosis</div>
    </div>
    <div class='section'>
        <h3>Instrucciones:</h3>
        <div class='content'>$instrucciones</div>
    </div>
    <div class='section'>
        <h3>Fecha:</h3>
        <div class='content'>" . date('d/m/Y') . "</div>
    </div>
    <div class='footer'>
        Este documento es una receta médica válida.
    </div>
</div>
</body>
</html>
";


    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream('reporte.pdf', array('Attachment' => false));
}

