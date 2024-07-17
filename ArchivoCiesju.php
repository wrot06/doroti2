<!DOCTYPE html>
<html lang="es">




<?php   
require 'rene/head.php';  
require "rene/conexion3.php";
?>

<style>
  .mi-tabla {
    border: 1px solid #ddd; /* Agrega un borde de 1 píxel y un color gris claro */
    border-collapse: collapse; /* Combina las celdas de la tabla en una sola línea */
    margin: 20px; /* Agrega un margen de 20 píxeles alrededor de la tabla */
  }
  .mi-tabla th, .mi-tabla td {
    border: 1px solid #ddd; /* Agrega un borde de 1 píxel y un color gris claro a todas las celdas */
    padding: 8px; /* Agrega un relleno de 8 píxeles a todas las celdas */
    text-align: left; /* Alinea el texto en la celda a la izquierda */
  }
  .mi-tabla th {
    background-color: #f2f2f2; /* Agrega un color de fondo gris claro a las celdas de encabezado */
  }
</style>

<body data-spy="scroll" data-target="#navbar" class="static-layout"><br><br>


<?php
$sql = "SELECT * FROM Carpetas ";
$resultado = mysqli_query($conec, $sql);
$contador=0;
?>




    <div class="title-wrap">


<h3>DOROTI, Sistema de Gestión Archivística de Prueba</h3>
<p>Centro de Investigaciones y Estudios Socio-Jurídicos</p>
<p>Universidad de Nariño</p>
<p>Proyecto: WHATHSON RENE ORDOÑEZ TORRES</p>

                    
                        <div class="row">

                            <div class="col-md-12 form-group">
                                <center>
                                  
<form action="pdf/RotuloCarpeta.php" method="post" target="_blank">
<table class="mi-tabla">
  <tr>
    
    <th>Caja</th>
    <th>Carpeta</th>
    <th>CaCa</th>
    <th>Car2</th>
    <th>Serie</th>
    <th>Sub-serie</th>
    <th>Titulo</th>
    <th>Fecha Inicial</th>
    <th>Fecha Final</th>
    <th>Folios</th>
    <th>Generar Rotulo</th>
  </tr>
  <?php
  if ($resultado->num_rows > 0) {
    // Salida de datos de cada fila
    while($fila = $resultado->fetch_assoc()) {

      if (($fila["Caja"] % 2) == 0) {
        //Es un número par
        $backgroundcolor="background-color: #BEC6DA";
        } else {        
        $backgroundcolor="";
        }
      ?>


      <tr>
        
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Caja"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Carpeta"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["CaCa"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Car2"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Serie"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Subs"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Titulo"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["FInicial"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["FFinal"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo htmlspecialchars($fila["Folios"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td style="<?php echo $backgroundcolor ?>"><?php echo '<button type="submit" name="consulta" value="'.$fila['id'].'" id="consulta" >Generar</button>'; ?></td>
      </tr>
      <?php
    }
  } else {
    echo "<tr><td colspan='11'>No se encontraron resultados</td></tr>";
  }
  $conn->close();
  ?>
</table>
</form>

                                </center>
                            </div> 
                        </div>
</div>


                