<?php
// Obtener la contraseña desde una variable de entorno
$password = "2024@#qwe123";

$servername = "localhost";
$username = "U.congreso";
$dbname = "congreso";

// Crear conexión
$conec = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conec->connect_error) {
    die("Connection failed: " . $conec->connect_error);
}

//echo "Conexión exitosa U.congreso";

