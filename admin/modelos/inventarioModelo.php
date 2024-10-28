<?php 

	require_once "mainModel.php";

	class inventarioModelo extends mainModel{

		/* 	Agregar inventario a DB
		*	@param: array de datos, desde controlador
		*  	@return: respuesta del servidor, exito/fallido
		*/
		protected static function agregar_inventario_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO productoservicio(codProdservi,prodserviNombre,prodserviTipo,prodserviPrecio) VALUES(:Cod,:Nombre,:Tipo,:Precio)");

			$sql->bindParam(":Cod",$datos['Codinventario']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->execute();
			  
			return $sql;
		}

		/* eliminar inventario
		* @param: $cod:codigo inventario a eliminar
		*/
		protected static function eliminar_inventario_modelo($cod){
			$sql=mainModel::conectar()->prepare("DELETE FROM productoservicio WHERE codProdservi=:COD");

			$sql->bindParam(":COD",$cod);
			$sql->execute();

			return $sql;
		}

		/* Buscar datos inventario
		* @param: tipo: unico,conteo $cod: codigo de inventario
		*/
		protected static function datos_inventario_modelo($tipo,$cod){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM productoservicio WHERE codProdservi=:COD");
				$sql->bindParam(":COD",$cod);	
			}elseif($tipo=="Conteo"){
				// TODOS 
				$sql=mainModel::conectar()->prepare("SELECT idProdservi FROM productoservicio");
			}
			$sql->execute();
			return $sql;
		}

		/* Editar inventario
		*	@param: $datos:array de datos
		*/
		protected static function actualizar_inventario_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE productoservicio SET prodserviNombre=:Nombre,prodserviTipo=:Tipo,prodserviPrecio=:Precio WHERE codProdservi=:COD");

			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Tipo",$datos['Tipo']);
			$sql->bindParam(":Precio",$datos['Precio']);
			$sql->bindParam(":COD",$datos['COD']);
			$sql->execute();

			return $sql;
		}
	}
?>
