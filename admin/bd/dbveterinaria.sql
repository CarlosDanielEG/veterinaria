-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para procedimiento dbveterinaria.add_detalle_temp
DELIMITER //
CREATE PROCEDURE `add_detalle_temp`(IN `codigo` VARCHAR(50), IN `cantidad` INT, IN `token_user` VARCHAR(50))
BEGIN
		DECLARE precio_actual DECIMAL(11,2);
		
		DECLARE repit_prod INT;
		DECLARE cant_actual INT default 0;
		DECLARE cant_final INT default 0;
		
		SELECT prodserviPrecio INTO precio_actual FROM productoservicio WHERE codProdservi = codigo;
		
		SET repit_prod=(SELECT COUNT(*) FROM detalle_temp tmp WHERE tmp.codproducto=codigo AND tmp.token_user=token_user); 
		
		IF (repit_prod>0) THEN
			SET cant_actual=(SELECT tmp.cantidad FROM detalle_temp tmp WHERE tmp.codproducto=codigo AND tmp.token_user=token_user);
			SET cant_final=cant_actual+cantidad;
			UPDATE detalle_temp tmp SET tmp.cantidad=cant_final WHERE tmp.codproducto=codigo AND tmp.token_user=token_user;
		ELSE
			INSERT INTO detalle_temp(token_user,codproducto,cantidad,precio_venta) VALUES(token_user,codigo,cantidad,precio_actual);
		END IF;
		
		SELECT tmp.correlativo, tmp.codproducto,p.prodserviNombre,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
		INNER JOIN productoservicio p
		ON tmp.codproducto = p.codProdservi
		WHERE tmp.token_user = token_user;
	
	END//
DELIMITER ;

-- Volcando estructura para tabla dbveterinaria.adjuntoshistorial
CREATE TABLE IF NOT EXISTS `adjuntoshistorial` (
  `idAdjunto` int NOT NULL AUTO_INCREMENT,
  `codHistorialM` varchar(50) DEFAULT NULL,
  `adjTipo` varchar(50) DEFAULT NULL,
  `adjFileName` text,
  `adjTitulo` varchar(100) DEFAULT NULL,
  `adjFecha` date DEFAULT NULL,
  PRIMARY KEY (`idAdjunto`),
  KEY `codHistorialM` (`codHistorialM`),
  CONSTRAINT `FK_adjuntoshistm_historialmascota` FOREIGN KEY (`codHistorialM`) REFERENCES `historialmascota` (`codHistorialM`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.adjuntoshistorial: ~0 rows (aproximadamente)

-- Volcando estructura para tabla dbveterinaria.citas
CREATE TABLE IF NOT EXISTS `citas` (
  `idCita` int NOT NULL AUTO_INCREMENT,
  `codCita` varchar(50) DEFAULT NULL,
  `codMascota` varchar(50) DEFAULT NULL,
  `dniCliente` int DEFAULT NULL,
  `citafechaEmitida` date DEFAULT NULL,
  `citaFechaProxima` date DEFAULT NULL,
  `citaHora` varchar(50) DEFAULT NULL,
  `citaMotivo` varchar(100) DEFAULT NULL,
  `citaEstado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idCita`),
  UNIQUE KEY `codCita` (`codCita`),
  KEY `codMascota` (`codMascota`),
  KEY `dniCliente` (`dniCliente`),
  CONSTRAINT `FK_citas_cliente` FOREIGN KEY (`dniCliente`) REFERENCES `cliente` (`clienteDniCedula`),
  CONSTRAINT `FK_citas_mascota` FOREIGN KEY (`codMascota`) REFERENCES `mascota` (`codMascota`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.citas: ~3 rows (aproximadamente)
INSERT INTO `citas` (`idCita`, `codCita`, `codMascota`, `dniCliente`, `citafechaEmitida`, `citaFechaProxima`, `citaHora`, `citaMotivo`, `citaEstado`) VALUES
	(2, 'CT-03378-1', 'CM10189-4', 545214785, '2022-05-22', '2022-05-22', '6:30 PM', 'consulta general', 'Procesada'),
	(4, 'CT-77220-3', 'CM03905-6', 656751545, '2022-05-22', '2022-05-22', '8:18 PM', 'consulta general x', 'Procesada'),
	(5, 'CT-17534-3', 'CM05804-5', 878788484, '2024-10-26', '2024-10-26', '10:03 PM', 'gfddgfdgf', 'Pendiente');

-- Volcando estructura para tabla dbveterinaria.cliente
CREATE TABLE IF NOT EXISTS `cliente` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `clienteDniCedula` int NOT NULL,
  `clienteNombre` varchar(50) DEFAULT NULL,
  `clienteApellido` varchar(50) DEFAULT NULL,
  `clienteGenero` varchar(20) DEFAULT NULL,
  `clienteTelefono` varchar(20) DEFAULT NULL,
  `clienteCorreo` varchar(150) DEFAULT NULL,
  `clienteDomicilio` varchar(150) DEFAULT NULL,
  `clienteFotoUrl` text,
  PRIMARY KEY (`idCliente`),
  UNIQUE KEY `dniCedula` (`clienteDniCedula`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.cliente: ~5 rows (aproximadamente)
INSERT INTO `cliente` (`idCliente`, `clienteDniCedula`, `clienteNombre`, `clienteApellido`, `clienteGenero`, `clienteTelefono`, `clienteCorreo`, `clienteDomicilio`, `clienteFotoUrl`) VALUES
	(2, 2147483647, 'Ines', 'Barrera', 'Femenino', '3232121524', 'ines@barrera.com', 'Guatemala', 'adjuntos/clientes-foto/32354512154_22_05_2022_154334Screenshot_2.png'),
	(3, 656751545, 'Jorge', 'Barrera', 'Masculino', '5656425124', 'jorge@barrera.com', 'Guatemala', 'vistas/images/avatar_user_cli/avatar_cli_12.svg'),
	(4, 878788484, 'Juan', 'Pérez', 'Masculino', '632361165', 'juan@perez.com', 'Guatemala', 'vistas/images/avatar_user_cli/avatar_cli_7.svg'),
	(8, 545214785, 'Juana', 'Paz', 'Femenino', '51545451', 'juanita@paz.com', 'Guatemala', 'vistas/images/avatar_user_cli/avatar_cli_3.svg'),
	(9, 32384114, 'Josefa', 'Jacinto', 'Masculino', '32655454', 'josefa@jacinto.com', 'Guatemala', 'vistas/images/avatar_user_cli/avatar_cli_6.svg');

-- Volcando estructura para procedimiento dbveterinaria.del_detalle_temp
DELIMITER //
CREATE PROCEDURE `del_detalle_temp`(`id_detalle` INT, `token` VARCHAR(50))
BEGIN 
  		DELETE FROM detalle_temp WHERE correlativo = id_detalle;
  		
  		SELECT tmp.correlativo, tmp.codproducto,p.prodserviNombre,tmp.cantidad,tmp.precio_venta FROM detalle_temp tmp
  		INNER JOIN productoservicio p
  		ON tmp.codproducto = p.codProdservi
  		WHERE tmp.token_user = token;
  END//
DELIMITER ;

-- Volcando estructura para tabla dbveterinaria.detalleventa
CREATE TABLE IF NOT EXISTS `detalleventa` (
  `idDetalle` int NOT NULL AUTO_INCREMENT,
  `codFactura` int DEFAULT NULL,
  `codProducto` varchar(50) DEFAULT NULL,
  `detalleCantidad` int DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idDetalle`),
  KEY `codProducto` (`codProducto`),
  KEY `codFactura` (`codFactura`),
  CONSTRAINT `FK_detalleVenta_producto` FOREIGN KEY (`codProducto`) REFERENCES `productoservicio` (`codProdservi`),
  CONSTRAINT `FK_detalleventa_venta` FOREIGN KEY (`codFactura`) REFERENCES `venta` (`idVenta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.detalleventa: ~8 rows (aproximadamente)
INSERT INTO `detalleventa` (`idDetalle`, `codFactura`, `codProducto`, `detalleCantidad`, `precio_venta`) VALUES
	(8, 5, 'CP-98586-1', 2, 5.50),
	(9, 6, 'CP-65052-3', 1, 50.00),
	(10, 7, 'CP-65052-3', 1, 50.00),
	(11, 8, 'CP-98586-1', 3, 5.50),
	(12, 9, 'CP-65052-3', 1, 50.00),
	(13, 10, 'CP-98586-1', 5, 5.50),
	(14, 11, 'CP-98586-1', 1, 5.50),
	(15, 11, 'CP-65052-3', 1, 50.00),
	(17, 12, 'CP-65052-3', 1, 50.00),
	(18, 13, 'CP-65052-3', 1, 50.00),
	(19, 14, 'CP-65052-3', 1, 50.00),
	(20, 15, 'CP-65052-3', 2, 50.00),
	(21, 16, 'CP-65052-3', 1, 50.00),
	(22, 17, 'CP-65052-3', 1, 50.00),
	(23, 18, 'CP-65052-3', 1, 50.00),
	(24, 19, 'CP-65052-3', 1, 50.00);

-- Volcando estructura para tabla dbveterinaria.detalle_temp
CREATE TABLE IF NOT EXISTS `detalle_temp` (
  `correlativo` int NOT NULL AUTO_INCREMENT,
  `token_user` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `codproducto` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio_venta` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`correlativo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

-- Volcando datos para la tabla dbveterinaria.detalle_temp: ~0 rows (aproximadamente)

-- Volcando estructura para tabla dbveterinaria.empresa
CREATE TABLE IF NOT EXISTS `empresa` (
  `idempresa` int NOT NULL AUTO_INCREMENT,
  `rif` varchar(50) NOT NULL DEFAULT '',
  `empresaNombre` varchar(100) DEFAULT NULL,
  `empresaDireccion` varchar(200) DEFAULT NULL,
  `empresaTelefono` varchar(20) DEFAULT NULL,
  `empresaCorreo` varchar(100) DEFAULT NULL,
  `empresaFotoUrl` text,
  `empresaMoneda` varchar(10) DEFAULT NULL,
  `empresaIva` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idempresa`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.empresa: ~0 rows (aproximadamente)
INSERT INTO `empresa` (`idempresa`, `rif`, `empresaNombre`, `empresaDireccion`, `empresaTelefono`, `empresaCorreo`, `empresaFotoUrl`, `empresaMoneda`, `empresaIva`) VALUES
	(2, '5454545454', 'Huellas Feliz', 'Guatemala Guatemala', '+50245118800', 'info@info.com', 'adjuntos/logo-empresa/huellas.jpg', 'S/', 5.00);

-- Volcando estructura para tabla dbveterinaria.especie
CREATE TABLE IF NOT EXISTS `especie` (
  `idEspecie` int NOT NULL AUTO_INCREMENT,
  `espNombre` varchar(50) NOT NULL,
  PRIMARY KEY (`idEspecie`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.especie: ~4 rows (aproximadamente)
INSERT INTO `especie` (`idEspecie`, `espNombre`) VALUES
	(10, 'Canino'),
	(11, 'Felino'),
	(12, 'Hamster'),
	(13, 'Tortugas');

-- Volcando estructura para tabla dbveterinaria.historialmascota
CREATE TABLE IF NOT EXISTS `historialmascota` (
  `idHistorial` int NOT NULL AUTO_INCREMENT,
  `codHistorialM` varchar(50) NOT NULL,
  `histFecha` date NOT NULL,
  `histHora` time NOT NULL,
  `histMotivo` varchar(100) NOT NULL,
  `histSintomas` varchar(350) NOT NULL,
  `histDiagnostico` varchar(350) NOT NULL,
  `histTratamiento` varchar(350) NOT NULL,
  `histCreador` varchar(100) NOT NULL,
  `codMascota` varchar(50) NOT NULL,
  PRIMARY KEY (`idHistorial`),
  UNIQUE KEY `codHistorialM` (`codHistorialM`),
  KEY `codMascota` (`codMascota`),
  CONSTRAINT `FK_historialmascota_mascota` FOREIGN KEY (`codMascota`) REFERENCES `mascota` (`codMascota`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.historialmascota: ~2 rows (aproximadamente)
INSERT INTO `historialmascota` (`idHistorial`, `codHistorialM`, `histFecha`, `histHora`, `histMotivo`, `histSintomas`, `histDiagnostico`, `histTratamiento`, `histCreador`, `codMascota`) VALUES
	(3, 'HM-75328-1', '2022-05-22', '09:44:31', 'dolor de panza', 'dolor de panza', 'se le ha dado mucha comida', 'un poquito de leche tibia', 'Administrador Principal', 'CM05804-5'),
	(4, 'HM-67303-2', '2022-05-22', '10:18:47', 'consulta general x', 'dolor de pancita', 'mucha comida', 'medicamento para dolor de pancita', 'Administrador Principal', 'CM03905-6'),
	(5, 'HM-67280-3', '2024-10-26', '09:56:25', 'consulta general', 'prueba', 'no se', 'que te imprta', 'Administrador Principal', 'CM10189-4');

-- Volcando estructura para tabla dbveterinaria.historialvacuna
CREATE TABLE IF NOT EXISTS `historialvacuna` (
  `idHistoriaVacuna` int NOT NULL AUTO_INCREMENT,
  `idVacuna` int DEFAULT '0',
  `historiavFecha` date DEFAULT NULL,
  `historiavProducto` varchar(150) DEFAULT NULL,
  `historiavObser` varchar(150) DEFAULT NULL,
  `codMascota` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idHistoriaVacuna`),
  KEY `Índice 2` (`idVacuna`),
  KEY `Índice 3` (`codMascota`),
  CONSTRAINT `FK_historialvacuna_mascota` FOREIGN KEY (`codMascota`) REFERENCES `mascota` (`codMascota`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_historialvacuna_vacunas` FOREIGN KEY (`idVacuna`) REFERENCES `vacunas` (`idVacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.historialvacuna: ~2 rows (aproximadamente)
INSERT INTO `historialvacuna` (`idHistoriaVacuna`, `idVacuna`, `historiavFecha`, `historiavProducto`, `historiavObser`, `codMascota`) VALUES
	(3, 9, '2022-05-22', 'tet', 'test', 'CM05804-5'),
	(4, 9, '2022-05-22', '62322', 'vacuna suministrada', 'CM03905-6');

-- Volcando estructura para tabla dbveterinaria.mascota
CREATE TABLE IF NOT EXISTS `mascota` (
  `idmascota` int NOT NULL AUTO_INCREMENT,
  `codMascota` varchar(50) DEFAULT NULL,
  `mascotaNombre` varchar(100) DEFAULT NULL,
  `mascotaFechaN` date DEFAULT NULL,
  `mascotaPeso` varchar(10) DEFAULT NULL,
  `mascotaColor` varchar(100) DEFAULT NULL,
  `idEspecie` int DEFAULT NULL,
  `idRaza` int DEFAULT NULL,
  `mascotaFoto` text,
  `mascotaSexo` varchar(10) DEFAULT NULL,
  `mascotaAdicional` varchar(200) DEFAULT NULL,
  `dniDueno` int DEFAULT NULL,
  PRIMARY KEY (`idmascota`),
  UNIQUE KEY `CodMascota` (`codMascota`),
  KEY `idEspecie` (`idEspecie`),
  KEY `idRaza` (`idRaza`),
  KEY `dniDueno` (`dniDueno`),
  CONSTRAINT `FK_mascota_cliente` FOREIGN KEY (`dniDueno`) REFERENCES `cliente` (`clienteDniCedula`),
  CONSTRAINT `FK_mascota_especie` FOREIGN KEY (`idEspecie`) REFERENCES `especie` (`idEspecie`),
  CONSTRAINT `FK_mascota_raza` FOREIGN KEY (`idRaza`) REFERENCES `raza` (`idRaza`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.mascota: ~6 rows (aproximadamente)
INSERT INTO `mascota` (`idmascota`, `codMascota`, `mascotaNombre`, `mascotaFechaN`, `mascotaPeso`, `mascotaColor`, `idEspecie`, `idRaza`, `mascotaFoto`, `mascotaSexo`, `mascotaAdicional`, `dniDueno`) VALUES
	(3, 'CM04366-1', 'Burbuja', '2022-02-04', '12', 'blanco', 10, 5, 'adjuntos/mascotas-foto/2147483647_22_05_2022_154528_1.jpg', 'Hembra', 'test test', 2147483647),
	(4, 'CM98122-2', 'Monty', '2022-02-06', '12', 'blanco', 11, 8, 'adjuntos/mascotas-foto/656751545_22_05_2022_181904_descarga.jpg', 'Macho', 'gato', 656751545),
	(5, 'CM84787-3', 'Newton', '2020-10-01', '23', 'verde', 13, 9, 'adjuntos/mascotas-foto/2147483647_22_05_2022_182218_Screenshot_1.png', 'Macho', '', 2147483647),
	(6, 'CM10189-4', 'Maximiliano', '2020-06-06', '32', 'gris', 10, 5, 'adjuntos/mascotas-foto/545214785_22_05_2022_191910_d420413ef1ab1f2919b6cf291eb0901f.jpg', 'Macho', 'ninguna informacion...', 545214785),
	(7, 'CM05804-5', 'Jotch', '2020-10-01', '12', 'barcino', 11, 8, 'adjuntos/mascotas-foto/878788484_22_05_2022_214240_IMG_20220404_133053_811.jpg', 'Macho', 'gato con mucha alegria', 878788484),
	(8, 'CM03905-6', 'Rafix', '2022-01-01', '1.5', 'barcino', 11, 8, 'adjuntos/mascotas-foto/656751545_22_05_2022_221542_IMG_20220404_133047_166.jpg', 'Macho', 'gato barcino', 656751545);

-- Volcando estructura para tabla dbveterinaria.notasmascotas
CREATE TABLE IF NOT EXISTS `notasmascotas` (
  `idNota` int NOT NULL AUTO_INCREMENT,
  `codMascota` varchar(50) DEFAULT NULL,
  `notaDescripcion` varchar(140) DEFAULT NULL,
  `notaFecha` date DEFAULT NULL,
  PRIMARY KEY (`idNota`),
  KEY `codMascota` (`codMascota`),
  CONSTRAINT `FK_notasm_mascota` FOREIGN KEY (`codMascota`) REFERENCES `mascota` (`codMascota`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.notasmascotas: ~2 rows (aproximadamente)
INSERT INTO `notasmascotas` (`idNota`, `codMascota`, `notaDescripcion`, `notaFecha`) VALUES
	(1, 'CM05804-5', 'gato muy dormilon', '2022-05-22'),
	(2, 'CM03905-6', 'sin problemas', '2022-05-22');

-- Volcando estructura para procedimiento dbveterinaria.procesar_venta
DELIMITER //
CREATE PROCEDURE `procesar_venta`(IN `cod_usuario` INT, IN `cod_cliente` INT, IN `token` VARCHAR(50), IN `tipo_pago` VARCHAR(50))
BEGIN
		DECLARE factura INT;
		DECLARE registros INT;
		DECLARE total DECIMAL(10,2);
		
		DECLARE nueva_existencia INT;
		DECLARE existencia_actual INT;
		
		DECLARE tmp_cod_producto varchar(50);
		DECLARE tmp_cant_producto INT;
		DECLARE a INT;
		SET a = 1;
		
		DROP TABLE IF EXISTS tbl_tmp_tokenuser;
		CREATE TEMPORARY TABLE tbl_tmp_tokenuser(
		id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		cod_prod VARCHAR(50),
		cant_prod INT(11));
		
		SET registros = (SELECT COUNT(*) FROM detalle_temp WHERE token_user = token);
		
		IF registros > 0 THEN 
			INSERT INTO tbl_tmp_tokenuser(cod_prod,cant_prod) SELECT codproducto,cantidad FROM detalle_temp WHERE  token_user = token;
			
			INSERT INTO venta(ventUsuario,dniCliente,ventMetodoPago) VALUES (cod_usuario,cod_cliente,tipo_pago);
			SET factura = LAST_INSERT_ID();
			
			INSERT INTO detalleventa(codFactura,codProducto,detalleCantidad,precio_venta) SELECT (factura) AS nofactura,codproducto,cantidad,precio_venta 
			FROM detalle_temp WHERE token_user = token;
			
			while a <= registros DO
				SELECT cod_prod,cant_prod INTO tmp_cod_producto,tmp_cant_producto FROM tbl_tmp_tokenuser WHERE id = a;
				SELECT prodserviStock INTO existencia_actual FROM productoservicio WHERE codProdservi = tmp_cod_producto;
				
				SET nueva_existencia = existencia_actual - tmp_cant_producto;
				UPDATE productoservicio SET prodserviStock = nueva_existencia WHERE codProdservi = tmp_cod_producto AND prodserviTipo = 'Producto';
				
				SET a=a+1; 
				
			END while;
			
			SET total = (SELECT SUM(cantidad*precio_venta) FROM detalle_temp WHERE token_user = token);
			UPDATE venta SET ventTotal = total WHERE idVenta = factura;
			
			DELETE FROM detalle_temp WHERE token_user = token;
			TRUNCATE TABLE tbl_tmp_tokenuser;
			SELECT * FROM venta WHERE idVenta = factura;
			
		ELSE
			SELECT 0;
		END IF;
	END//
DELIMITER ;

-- Volcando estructura para tabla dbveterinaria.productoservicio
CREATE TABLE IF NOT EXISTS `productoservicio` (
  `idProdservi` int NOT NULL AUTO_INCREMENT,
  `codProdservi` varchar(50) DEFAULT NULL,
  `prodserviNombre` varchar(100) DEFAULT NULL,
  `prodserviTipo` varchar(50) DEFAULT NULL,
  `prodserviPrecio` decimal(11,2) DEFAULT NULL,
  `prodserviStock` int DEFAULT NULL,
  PRIMARY KEY (`idProdservi`),
  UNIQUE KEY `codProducto` (`codProdservi`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.productoservicio: ~3 rows (aproximadamente)
INSERT INTO `productoservicio` (`idProdservi`, `codProdservi`, `prodserviNombre`, `prodserviTipo`, `prodserviPrecio`, `prodserviStock`) VALUES
	(3, 'CP-98586-1', 'Concentrado para Gato Libra', 'Producto', 5.50, 89),
	(5, 'CP-65052-3', 'Collar AntiPulga', 'Producto', 50.00, 37);

-- Volcando estructura para tabla dbveterinaria.raza
CREATE TABLE IF NOT EXISTS `raza` (
  `idRaza` int NOT NULL AUTO_INCREMENT,
  `razaNombre` varchar(100) DEFAULT NULL,
  `idEspecie` int DEFAULT NULL,
  PRIMARY KEY (`idRaza`),
  KEY `idEspecie` (`idEspecie`),
  CONSTRAINT `FK_raza_especie` FOREIGN KEY (`idEspecie`) REFERENCES `especie` (`idEspecie`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.raza: ~8 rows (aproximadamente)
INSERT INTO `raza` (`idRaza`, `razaNombre`, `idEspecie`) VALUES
	(5, 'Pug', 10),
	(6, 'Dalmata', 10),
	(7, 'Angora', 11),
	(8, 'Persa', 11),
	(9, 'galápago', 13),
	(10, 'Cumberland', 13),
	(11, 'enano chino', 12),
	(12, 'enano ruso', 12);

-- Volcando estructura para tabla dbveterinaria.recetas
CREATE TABLE IF NOT EXISTS `recetas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medicamento` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosis` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instrucciones` text COLLATE utf8mb4_general_ci,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_cita` int NOT NULL,
  `id_mascota` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla dbveterinaria.recetas: ~1 rows (aproximadamente)
INSERT INTO `recetas` (`id`, `medicamento`, `dosis`, `instrucciones`, `fecha`, `id_cita`, `id_mascota`) VALUES
	(1, 'Prueba', '1 vaso', 'instrcucción aqui', '2024-10-28 00:56:48', 5, 7),
	(2, 'Nueva Receta', 'hola', 'como estas', '2024-10-28 01:07:01', 5, 7),
	(3, 'prueba', '1 vaso', 'instrucciones aqui', '2024-10-28 01:16:02', 5, 7);

-- Volcando estructura para tabla dbveterinaria.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `userDni` int DEFAULT NULL,
  `userNombre` varchar(50) DEFAULT NULL,
  `userApellido` varchar(50) DEFAULT NULL,
  `userTelefono` varchar(20) DEFAULT NULL,
  `userDomicilio` varchar(150) DEFAULT NULL,
  `userEmail` varchar(150) DEFAULT NULL,
  `userFoto` text,
  `userUsuario` varchar(50) DEFAULT NULL,
  `userClave` varchar(500) DEFAULT NULL,
  `userEstado` varchar(50) DEFAULT NULL,
  `userPrivilegio` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userDni` (`userDni`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.usuarios: ~0 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `userDni`, `userNombre`, `userApellido`, `userTelefono`, `userDomicilio`, `userEmail`, `userFoto`, `userUsuario`, `userClave`, `userEstado`, `userPrivilegio`) VALUES
	(1, 3132, 'Administrador', 'Principal', '02511111111', 'Venezuela-Lara', 'admin@correo.com', 'adjuntos/user-sistema-foto/03132_26_10_2024_221105ai-generated-8415356_1280.jpg', 'admin', 'Rm5jTEIzZTVPSHkrQnhrK3VKNDlJZz09', 'Activa', '1');

-- Volcando estructura para tabla dbveterinaria.vacunas
CREATE TABLE IF NOT EXISTS `vacunas` (
  `idVacuna` int NOT NULL AUTO_INCREMENT,
  `vacunaNombre` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci DEFAULT NULL,
  `especieId` int DEFAULT NULL,
  PRIMARY KEY (`idVacuna`),
  KEY `Índice 2` (`especieId`),
  CONSTRAINT `FK_vacunas_especie` FOREIGN KEY (`especieId`) REFERENCES `especie` (`idEspecie`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.vacunas: ~8 rows (aproximadamente)
INSERT INTO `vacunas` (`idVacuna`, `vacunaNombre`, `especieId`) VALUES
	(3, 'Labrador', 10),
	(4, 'Galgo', 10),
	(5, 'Husky', 10),
	(6, 'Samoyedo', 10),
	(7, 'Dálmata', 10),
	(8, 'Pug', 10),
	(9, 'vacuna contra los parasitos', 11),
	(10, 'vacuna antirrabia', 11);

-- Volcando estructura para tabla dbveterinaria.venta
CREATE TABLE IF NOT EXISTS `venta` (
  `idVenta` int NOT NULL AUTO_INCREMENT,
  `dniCliente` int DEFAULT NULL,
  `ventUsuario` int DEFAULT NULL,
  `ventFecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `ventMetodoPago` varchar(50) DEFAULT NULL,
  `ventTotal` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`idVenta`),
  KEY `dniCliente` (`dniCliente`),
  KEY `Índice 3` (`ventUsuario`),
  CONSTRAINT `FK_venta_cliente` FOREIGN KEY (`dniCliente`) REFERENCES `cliente` (`clienteDniCedula`),
  CONSTRAINT `FK_venta_usuarios` FOREIGN KEY (`ventUsuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla dbveterinaria.venta: ~7 rows (aproximadamente)
INSERT INTO `venta` (`idVenta`, `dniCliente`, `ventUsuario`, `ventFecha`, `ventMetodoPago`, `ventTotal`) VALUES
	(5, 545214785, 1, '2022-05-22 16:45:19', 'Efectivo', 11.00),
	(6, 656751545, 1, '2022-05-22 16:45:59', 'Efectivo', 50.00),
	(7, 656751545, 1, '2022-05-22 19:46:33', 'Efectivo', 50.00),
	(8, 545214785, 1, '2022-05-22 19:47:15', 'Efectivo', 16.50),
	(9, 656751545, 1, '2022-05-22 20:20:14', 'Efectivo', 50.00),
	(10, 656751545, 1, '2022-05-22 20:20:42', 'Efectivo', 27.50),
	(11, 32384114, 1, '2024-10-26 20:38:48', 'Efectivo', 55.50),
	(12, 32384114, 1, '2024-10-26 21:28:07', 'Efectivo', 50.00),
	(13, 32384114, 1, '2024-10-26 21:30:36', 'Efectivo', 50.00),
	(14, 32384114, 1, '2024-10-26 21:38:49', 'Efectivo', 50.00),
	(15, 32384114, 1, '2024-10-27 20:17:45', 'Efectivo', 100.00),
	(16, 32384114, 1, '2024-10-27 20:19:46', 'Efectivo', 50.00),
	(17, 32384114, 1, '2024-10-27 20:26:00', 'Credito', 50.00),
	(18, 32384114, 1, '2024-10-27 20:28:11', 'Efectivo', 50.00),
	(19, 32384114, 1, '2024-10-27 20:29:06', 'Efectivo', 50.00);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
