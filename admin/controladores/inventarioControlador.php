<?php 

 	if ($peticionAjax) {
	  require_once "../modelos/inventarioModelo.php";
	} else {
	  require_once "./modelos/inventarioModelo.php";
	}

	class inventarioControlador extends inventarioModelo{

		/* Agregar Inventario: limpiar entradas, validar, enviar a modelo
		*/
		public function agregar_inventario_controlador(){
			$nombre=mainModel::limpiar_cadena($_POST['prodservi_nombre_reg']);
			$tipo=mainModel::limpiar_cadena($_POST['prodservi_tipo_reg']);
			$precio=mainModel::limpiar_cadena($_POST['prodservi_precio_reg']);



			// ------- Campos vacios ---------------->
			if($nombre=="" || $tipo=="" || $precio==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Debes llenar todos los campos",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			// Convertir a decimal precio
			$precio_decimal=mainModel::tofloat($precio);

			if($tipo!="Producto" && $tipo!="Servicio"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de la Servicio no es valido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de Servicio no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			if(mainModel::verificar_datos("^\d{1,3}(,\d{3})*(\.\d+)?$",$precio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			// ----- CODIGO PRODUCTO O SERVICIO ----------
			$consulta=mainModel::ejecutar_consulta_simple("SELECT idProdservi FROM productoservicio ");
            $numero=($consulta->rowCount())+1;
            if($tipo=="Producto"){
            	$codinventario=mainModel::generar_codigo_aleatorio("CP-",5,$numero);
            }else{
            	// codigo para servicios
            	$codinventario=mainModel::generar_codigo_aleatorio("CS-",5,$numero);
            }

			/*---PREPARAR CARGAR---*/
			$datos = [
				"Codinventario" => $codinventario,
				"Nombre" => $nombre,
				"Tipo" => $tipo,
				"Precio" => $precio_decimal,
			];

			// instancia
			$guardar_inventario=inventarioModelo::agregar_inventario_modelo($datos);
			
			if($guardar_inventario->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Servicio registrado",
					"Texto"=>"Los datos fueron registrados",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido registrar el Servicio",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);
		} // fin  agregar_inventario_controlador

		/* paginador inventario
		* @param: $pagina: pagina actual,$registros: registros a mostrar,$privilegio: acultar algunas acciones,$url:la vista para botones $busqueda: lista especie o especie buscar
		*/
		public function paginador_inventario_controlador($pagina,$registros,$privilegio,$url,$busqueda){
			$pagina=mainModel::limpiar_cadena($pagina);
			$registros=mainModel::limpiar_cadena($registros);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			
			$url=mainModel::limpiar_cadena($url);
			$url=SERVERURL.$url."/";

			$busqueda=mainModel::limpiar_cadena($busqueda);

			$tabla="";
			// operador ternario, false: llevar a pag 1
			$pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;

			$inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;
			// consulta bd
			if(isset($busqueda) && $busqueda!=""){
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM productoservicio,empresa WHERE prodserviNombre LIKE '%$busqueda%' ORDER BY idProdservi DESC LIMIT $inicio,$registros";
			}else{
				$consulta="SELECT SQL_CALC_FOUND_ROWS * FROM productoservicio,empresa ORDER BY idProdservi DESC LIMIT $inicio,$registros";
			}

			$conexion = mainModel::conectar();
			$datos = $conexion->query($consulta);
			$datos = $datos->fetchAll();

			$total = $conexion->query("SELECT FOUND_ROWS()");
			$total = (int) $total->fetchColumn();

			$Npaginas=ceil($total/$registros);

			$tabla.='<div class="table-responsive">
			          <table class="table table-hover mb-0">
			              <thead>
			                  <tr class="align-self-center">
			                      <th>#</th>
			                      <th>Nombre</th>
			                      <th>Tipo</th>
			                      <th>Precio</th>
			                      <th>Acciones</th>
			                  </tr>
			              </thead>
			              <tbody>';

					if($total>=1 && $pagina<=$Npaginas){
						$contador=$inicio+1;
						$reg_inicio=$inicio+1;
						setlocale(LC_MONETARY, 'PEN');
						foreach($datos as $rows){
							$precio_form = number_format($rows['prodserviPrecio'],2,'.',',');
							$tabla.='
								 <tr>
			                      <td>'.$contador.'</td>
			                      <td>'.$rows['prodserviNombre'].'</td>
			                      <td>'.$rows['prodserviTipo'].'</td>
			                      <td>'.$precio_form.' '.$rows['empresaMoneda'].'</td>
			                      <td class="d-flex flex-row">
			                      	';
			                      	// -----EDITAR BOTON -----
			                      	if ($privilegio<=2) {
			              				$tabla.='<a href="'.SERVERURL.'editProdservi/'.mainModel::encryption($rows['codProdservi']).'/" class="btn btn-success btn-circle btn-sm">
					                          <i class="fas fa-edit fa-sm"></i>
					                        </a>

					                        ';
					                }
					                
					                if($privilegio==1){
					                	// ----- ELIMINAR BOTON ----->
			                        $tabla.=' 

			                        <form class="FormularioAjax ml-2" action="'.SERVERURL.'ajax/inventarioAjax.php" method="POST" data-form="delete">
		                              	<input type="hidden" name="inventario_id_del" value="'.mainModel::encryption($rows['codProdservi']).'">
		                              	
		                              	<input type="hidden" name="privilegio_user" value="'.mainModel::encryption($privilegio).'">
		                              	

				                        <button type="submit" class="btn btn-danger btn-circle btn-sm">
				                          <i class="fas fa-trash-alt fa-sm"></i>
				                        </button>
		                              	
		                              </form>
			                        ';
					                }

			                       $tabla.=' 
			                      </td>
			                  </tr>
			                 ';

							$contador++;
						}
						$reg_final=$contador-1; 
					}else{
						if($total>=1){
							$tabla.='<tr><td colspan="9">
								<a href="'.$url.'" class="btn btn-sm btn-primary btn-raised">
					                    Haga clic aca para recargar el listado
					                </a>
							</td></tr>';
						}else{

						}
						$tabla.='<tr><td colspan="9">No hay registros en el sistema</td></tr>';
					}                
					

					$tabla.='</tbody></table></div>';

					// paginador botones

					if($total>=1 && $pagina<=$Npaginas){
						$tabla.='<p class="text-right">Mostrando inventario '.$reg_inicio.' al '.$reg_final.' de un total de '.$total.'</p>';
						$tabla.=mainModel::paginador_tablas($pagina,$Npaginas,$url,5);
					}

					return $tabla;	                

		} //fin controlador paginador

		/* Elimimar inventario
		*	@return: json_encode(array): alerta con respueta de servidor y validaciones
		*/
		public function eliminar_inventario_controlador(){
			$id=mainModel::decryption($_POST['inventario_id_del']);
			$id=mainModel::limpiar_cadena($id);
			$privilegio=mainModel::decryption($_POST['privilegio_user']);
			$privilegio=mainModel::limpiar_cadena($privilegio);
			

			// ------- comprobar especie en DB ----->
			$check_inventario = mainModel::ejecutar_consulta_simple("SELECT codProdservi FROM productoservicio WHERE codProdservi='$id'");
			if($check_inventario->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El Servicio no existe en el sistema",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			// --- comprobar privilegio ----->
			if($privilegio!=1){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No tienes los permisos necesarios para realizar esta acción",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			// comprobar con clave foranea tabla raza
			$check_factura = mainModel::ejecutar_consulta_simple("SELECT codProducto FROM detalleventa WHERE codProducto='$id' ");
			if($check_factura->rowCount()>0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No podemos eliminar este Servicio debido a que tiene factura/s asociadas",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			
			$eliminar_inventario=inventarioModelo::eliminar_inventario_modelo($id);
			if($eliminar_inventario->rowCount()==1){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Servicio eliminado",
					"Texto"=>"El Servicio a sido eliminado del sistema",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido eliminar el Servicio, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);

		} // fin controlador eliminar

		/*	Datos inventario
		* @param: $tipo: unico,conteo(total), $cod:(clave unica)
		*/
		public static function datos_inventario_controlador($tipo,$cod){
			$tipo=mainModel::limpiar_cadena($tipo);
			$cod=mainModel::decryption($cod);
			$cod=mainModel::limpiar_cadena($cod);

			return inventarioModelo::datos_inventario_modelo($tipo,$cod);
		} // fin datos_inventario_controlador

		/* Actualizar Inventario
		*	@return: json_encode(array): respuesta de servidor y validaciones
		*/
		public function actualizar_inventario_controlador(){
			$cod=mainModel::decryption($_POST['inventario_cod_up']);
			$cod=mainModel::limpiar_cadena($cod);

			// camprobar codigo en db
			$check_inventario=mainModel::ejecutar_consulta_simple("SELECT * FROM productoservicio WHERE codProdservi='$cod'");

			if($check_inventario->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El Servicio no se encuentra registrado en el sistema, intente nuevamente",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_inventario->fetch();
			}

			$nombre=mainModel::limpiar_cadena($_POST['prodservi_nombre_edit']);
			$tipo=mainModel::limpiar_cadena($_POST['prodservi_tipo_edit']);
			$precio=mainModel::limpiar_cadena($_POST['prodservi_precio_edit']);


			// ------- Campos vacios ---------------->
			if($nombre=="" || $tipo=="" || $precio==""){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Debes llenar todos los campos",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			// Convertir a decimal precio
			$precio_decimal=mainModel::tofloat($precio);

			if($tipo!="Producto" && $tipo!="Servicio"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El tipo de la Servicio no es valido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}",$nombre)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El nombre de Servicio no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}
			if(mainModel::verificar_datos("^\d{1,3}(,\d{3})*(\.\d+)?$",$precio)){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El precio no coincide con el formato solicitado",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			/*---PREPARAR CARGAR---*/
			$datos = [
				"Nombre" => $nombre,
				"Tipo" => $tipo,
				"Precio" => $precio_decimal,
				"COD" => $cod
			];

			// instancia A Modelo ->
			if(inventarioModelo::actualizar_inventario_modelo($datos)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos Actualizados",
					"Texto"=>"Los datos han sido actualizados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido Actualizar los datos, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);


		}// fin actualizar_inventario_controlador

		/* Agregar stock a productos
		*	@return: json_encode(array): respuesta de servidor y validaciones
		*/
		public function actualizar_stockprod_controlador(){
			// $cod=mainModel::decryption();
			$cod=mainModel::limpiar_cadena($_POST['cod_producto_stockup']);

			// camprobar codigo en db
			$check_inventario=mainModel::ejecutar_consulta_simple("SELECT * FROM productoservicio WHERE codProdservi='$cod'");

			if($check_inventario->rowCount()<=0){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"El Servicio no se encuentra registrado en el sistema, intente nuevamente",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}else{
				$campos=$check_inventario->fetch();
			}

			// verificar tipo: producto
			if($campos['prodserviTipo']!="Producto"){
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"Tipo de Servicio no valido",
					"Tipo"=>"error"
				];
				echo json_encode($alerta);
				exit();
			}

			
			/*---PREPARAR CARGAR---*/
			$datos = [
				"Nombre" => $campos['prodserviNombre'],
				"Tipo" => $campos['prodserviTipo'],
				"Precio" => $campos['prodserviPrecio'],
				"COD" => $cod
			];

			// instancia A Modelo ->
			if(inventarioModelo::actualizar_inventario_modelo($datos)){
				$alerta=[
					"Alerta"=>"recargar",
					"Titulo"=>"Datos Actualizados",
					"Texto"=>"Los datos han sido actualizados con exito",
					"Tipo"=>"success"
				];
			}else{
				$alerta=[
					"Alerta"=>"simple",
					"Titulo"=>"Ocurrió un error inesperado",
					"Texto"=>"No hemos podido Actualizar los datos, intente nuevamente",
					"Tipo"=>"error"
				];
			}
			echo json_encode($alerta);




		}

	} // fin class