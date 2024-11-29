<?php
// Configuración de la conexión a la base de datos
$servername = "localhost"; // El servidor de la base de datos, usualmente "localhost"
$username = "derecho2";        // Tu usuario de la base de datos
$password = "#Derecho2024$";            // Tu contraseña de la base de datos
$dbname = "Semillero"; // El nombre de la base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir la línea de investigación seleccionada
$linea_investigacion = '';

// Si el formulario se envió, obtener la línea de investigación seleccionada
if (isset($_POST['linea_investigacion'])) {
    $linea_investigacion = mysqli_real_escape_string($conn, $_POST['linea_investigacion']);
}

// Consulta SQL para obtener los estudiantes de la línea de investigación seleccionada
$sql = "SELECT * FROM `2024` WHERE linea_investigacion LIKE '%$linea_investigacion%'";

// Ejecutar la consulta
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes por Línea de Investigación</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        select, input[type="submit"] {
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

    <!-- Formulario para seleccionar la línea de investigación -->
    <h2>Selecciona una Línea de Investigación</h2>
    <form method="post" action="">
        <select name="linea_investigacion">
            <option value="">Todos los Estudiantes Inscritos</option>
            <option value="Derecho Procesal (Omar Cárdenas y Duvan Chaves)">Derecho Procesal (Omar Cárdenas, Duvan Chaves)</option>
            <option value="Estudio del Derecho Penal Internacional y áreas afines">Estudio del Derecho Penal Internacional y áreas afines (Diego Alejandro Palacios Parra, Vicente Arbey Villota Cruz)</option>
            <option value="Arbitraje en derecho comercial internacional">Arbitraje en derecho comercial internacional (Mario F. Muñoz Agredo, Iván Fernando Zarama Concha, Omar Alfonso Cárdenas Caycedo)</option>
            <option value="Transparencia en la Contratación Pública en las Entidades Públicas de Nariño">Transparencia en la Contratación Pública en las Entidades Públicas de Nariño (Javier Alberto Peñaranda Méndez)</option>
            <option value="Inteligencia Artificial y Derecho">Inteligencia Artificial y Derecho (Juan Pablo Rosero, Omar Cárdenas Caycedo)</option>
            <option value="Derecho del mundo del trabajo">Derecho del mundo del trabajo (Luz Amalia Andrade Arévalo, Juan Pablo Rosero Gomajoa)</option>
            <option value="Derecho Público">Derecho Público (Cristhian Alexander Pereira Otero, Álvaro Alfonso Patiño Yepes, Maria Alexandra Ruíz Cabrera)</option>
            <option value="Derechos sociales y humanos">Derechos sociales y humanos (Víctor Guerrero, Julio Javier Leytón, Luz Amalia Andrade)</option>
            <option value="Derecho laboral - Riesgos laborales">Derecho laboral - Riesgos laborales (Víctor Guerrero)</option>
            <option value="Derechos Humanos - Derecho Internacional de Derechos Humanos">Derechos Humanos - Derecho Internacional de Derechos Humanos (Manuel Antonio Coral, Leonardo Enriquez, Cristhian Pereira)</option>
            <option value="Derecho Penal y Derecho Procesal Penal">Derecho Penal y Derecho Procesal Penal (Juan Carlos Lagos Mora)</option>
            <option value="Derecho laboral - acoso laboral">Derecho laboral - acoso laboral (Mónica María Urresta Tascón)</option>
            <option value="Justicia Especial para la Paz (JEP)">Justicia Especial para la Paz (JEP) (Álvaro Patiño, Vicente Arbey Villota)</option>
            <option value="Derecho agrario con enfoque en derecho a la alimentación">Derecho agrario con enfoque en derecho a la alimentación (Aura Torres)</option>
            <option value="Derecho Procesal (Luis Alfonso Torres)">Derecho Procesal (Luis Alfonso Torres)</option>
            <!-- Agrega más líneas de investigación según sea necesario -->
        </select>
        <input type="submit" value="Mostrar Estudiantes">
    </form>

    <h2><?php echo htmlspecialchars($linea_investigacion); ?></h2>

    <?php
    $contador=1;
    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Num</th>                     
                    <th>Código Estudiantil</th>                  
                    <th>Nombre Estudiante</th>                    
                    <th>Año Académico</th>
                   
                    <th>Correo</th>
                    
                    <th>Teléfono Celular</th>
                </tr>";

        // Mostrar los resultados
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $contador . "</td>
                    <td>" . $row["codigo_estudiantil"] . "</td>                    
                    <td>" . $row["nombre_completo_estudiante"] . "</td>                    
                    <td>" . $row["ano_academico"] . "</td>
            
                    <td>" . $row["correo_personal"] ."<br>". $row["correo_institucional"] . "</td>
                    <td><a href='https://api.whatsapp.com/send?phone=57" . $row['telefono_celular_contacto'] . "' target='_blank'>" . $row['telefono_celular_contacto'] . "</a></td>
                </tr>";
                $contador+=1;
        }
        echo "</table>";
        
    } else {
        echo "No se encontraron estudiantes en esta línea de investigación.";
    }

    // Cerrar la conexión
    $conn->close();
    ?>



</body>
</html>