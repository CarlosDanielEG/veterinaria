<?php
if ($peticionAjax) {
    require_once "../modelos/recetaModelo.php";
} else {
    require_once "./modelos/recetaModelo.php";
}

class recetaControlador extends recetaModelo
{

    /* Agregar especie: limpiar entradas, validar, enviar a modelo
		*/
    public function agregar_controlador()
    {
        // Obtener datos del formulario
        $medicamento = $_POST['medicamento'];
        $dosis = $_POST['dosis'];
        $instrucciones = $_POST['instrucciones'];
        $idCita = $_POST['idCita'];
        $idmascota = $_POST['idmascota'];

        $datos = [
            "medicamento" => $medicamento,
            "dosis" => $dosis,
            "instrucciones" => $instrucciones,
            "id_cita" => $idCita,
            "id_mascota" => $idmascota
        ];

        // instancia
        $guardar = recetaModelo::agregar_modelo($datos);

        if ($guardar) { // Cambiar la condición para verificar si $guardar es un ID válido
            $alerta = [
                "Tipo" => "success",
                "msg" => "Receta Registrado",
                "ID" => $guardar // Incluye el ID insertado en la respuesta
            ];
        } else {
            $alerta = [
                "Tipo" => "error",
                "msg" => "Error al crear receta",
            ];
        }
        echo json_encode($alerta);
    }

    public function getReceta($id) {
        $respuesta = recetaModelo::getReceta($id);
        return $respuesta;
    }
}
