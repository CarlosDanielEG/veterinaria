<?php

const SERVER = "localhost";
const BD = "veterinariaa";
const USER = "root";
const PASS = "";

// DSN (Data Source Name) para PDO
const SGBD = "mysql:host=" . SERVER . ";dbname=" . BD;

// Métodos de encriptación: no cambiar una vez haya registro en la BD
// NO SE PUEDE MODIFICAR METHOD
// SECRET_KEY: llave secreta se puede modificar
// SECRET_IV: número único, colocar cualquier número
const METHOD = "AES-256-CBC"; 
const SECRET_KEY = '$VT@2020';
const SECRET_IV = '881992';

// Función para crear una conexión a la base de datos
function getConnection() {
    try {
        // Crear una instancia de PDO
        $pdo = new PDO(SGBD, USER, PASS);
        // Establecer el modo de error de PDO a excepción
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error de conexión: " . $e->getMessage();
        return null;
    }
}


?>
