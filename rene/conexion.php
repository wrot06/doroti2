<?php	

$servername = "localhost"; // Cambia esto si es necesario
$username = "congresoU";
$password = "!”#qwe123";
$dbname = "congreso";

$conec = new mysqli($servername, $username, $password, $dbname);


if (!$conec) {
    die("Connection failed: " . mysqli_connect_error());
}




	