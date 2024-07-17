<?php	

$servername = "localhost"; // Cambia esto si es necesario
$username = "usuario2024";
$password = "Werdwre854";
$dbname = "seminario2024";

$conec = new mysqli($servername, $username, $password, $dbname);


if (!$conec) {
    die("Connection failed: " . mysqli_connect_error());
}




	