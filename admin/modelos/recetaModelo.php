<?php


require_once "mainModel.php";

/**
 * 
 */
class recetaModelo extends mainModel
{

    /* 	Agregar especie a DB
		*	@param: array de datos, desde controlador
		*  	@return: respuesta del servidor, exito/fallido
		*/
    protected static function agregar_modelo($datos)
    {
        $db = mainModel::conectar();
        $sql = $db->prepare("INSERT INTO recetas (medicamento, dosis, instrucciones, id_cita, id_mascota) VALUES(:medicamento, :dosis, :instrucciones, :id_cita, :id_mascota)");

        $sql->bindParam(":medicamento", $datos['medicamento']);
        $sql->bindParam(":dosis", $datos['dosis']);
        $sql->bindParam(":instrucciones", $datos['instrucciones']);
        $sql->bindParam(":id_cita", $datos['id_cita']);
        $sql->bindParam(":id_mascota", $datos['id_mascota']);

        if ($sql->execute()) {
            return $db->lastInsertId(); // Retorna el ID insertado
        } else {
            return false; // Manejo de error si la inserción falla
        }
    }

    public function getReceta($id)
    {
        // Conectar a la base de datos
        $db = mainModel::conectar();

        // Preparar la consulta
        $sql = $db->prepare("SELECT r.*, m.mascotaNombre FROM recetas r JOIN mascota m ON r.id_mascota = m.idmascota WHERE r.id = :id");

        // Asignar el parámetro
        $sql->bindParam(":id", $id);

        // Ejecutar la consulta
        $sql->execute();

        // Recuperar la receta
        $receta = $sql->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró la receta
        if ($receta) {
            return $receta; // Retorna el array asociativo de la receta
        } else {
            return null; // Retorna null si no se encontró la receta
        }
    }
}
