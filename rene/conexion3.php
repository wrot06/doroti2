<?php	

$servername = "localhost"; // Cambia esto si es necesario
$username = "UArchivoCIESJU";
$password = "123UCiesjuArchivo";
$dbname = "ArchivoCIESJU";

$conec = new mysqli($servername, $username, $password, $dbname);


if (!$conec) {
    die("Connection failed: " . mysqli_connect_error());
}




	