<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doroti</title>

    <?php   
    require 'rene/head.php';  
    require "rene/conexion4.php";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header('Location: login2.php'); // Redirige al inicio de sesión si no está autenticado
        exit();
    }

    if (isset($_POST['cerrar_seccion'])) {
        session_destroy();
        header("Location: login2.php"); // Redirige a la página deseada
        exit();
    }
    ?>

    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="buscador" style="display: flex; justify-content: flex-end; align-items: center;">
    
    <form method="POST" style="margin-right: 15px;">
        <input type="submit" name="cerrar_seccion" value="Salir" style="text-align:left;">
    </form>
    <img src="img/Doroti Logo Horizontal 2.jpg" style="margin-right: 15px; height: 18px;">
    <input type="text" id="search" placeholder="Buscar..." onkeyup="searchTable()">
</div>

<div id="contenedor">
    <table class="mi-tabla">
        <thead>
            <tr>
                <th></th>
                <th style="text-align: center;">Caja</th>
                <th style="text-align: center;">Carpeta</th>
                <th>Serie</th>
                <th>Sub-serie</th>
                <th>Título</th>
                <th style="text-align: center;">Fecha Inicial</th>
                <th style="text-align: center;">Fecha Final</th>
                <th style="text-align: center;">Folios</th>
                <th style="text-align: center;">Rotulos</th>
                <th style="text-align: center;">Rotulo</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            $sql = "SELECT * FROM Carpetas ORDER BY Caja";
            $resultado = mysqli_query($conec, $sql);
                        
            while($fila = $resultado->fetch_assoc()) {
                $colorAcordeon = ($fila["Caja"] % 2 == 0) ? "#e7f4ff" : "#FFFFFF";
            ?>
                <tr style="background-color: <?= $colorAcordeon; ?>;">
                    <td style="text-align: center;"><button class="accordion">v</button></td>
                    <td style="text-align: center;"><?= htmlspecialchars($fila["Caja"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($fila["Carpeta"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><b><?= htmlspecialchars($fila["Serie"], ENT_QUOTES, 'UTF-8') ?></b></td>
                    <td><?= htmlspecialchars($fila["Subs"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($fila["Titulo"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($fila["FInicial"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td style="text-align: center;"><?= htmlspecialchars($fila["FFinal"], ENT_QUOTES, 'UTF-8') ?></td>
                    <td style="text-align: center;"><b><?= htmlspecialchars($fila["Folios"], ENT_QUOTES, 'UTF-8') ?></b></td>
                    <td style="text-align: center;">
                        <form action="pdf/RotuloCarpetaConsul.php" method="post" target="_blank">
                            <button type="submit" name="consulta" value="<?= $fila['id'] ?>">Carpeta <?= htmlspecialchars($fila['Carpeta'], ENT_QUOTES, 'UTF-8') ?></button>
                        </form>
                    </td>
                    <?php if ($fila["Carpeta"] == 1): ?>
                    <td style="text-align: center;">
                        <form action="pdf/RotuloCajaConsul.php" method="post" target="_blank">
                            <button type="submit" name="consulta" value="<?= $fila['Caja'] ?>">Caja <?= htmlspecialchars($fila['Caja'], ENT_QUOTES, 'UTF-8') ?></button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>

                <tr class="panel" style="display: none;">
                <td colspan="11" class="alinear-derecha">

                <div style="width: 90%; display: flex; justify-content: center; padding-right: 5%;">
                    <table class="mi-tabla2">
                        <?php
                        $sql2 = "SELECT * FROM IndiceDocumental WHERE Caja = '" . $fila['Caja'] . "' AND Carpeta = '" . $fila['Car2'] . "'";
                        $resultado2 = mysqli_query($conec, $sql2);
                        
                        if ($resultado2) {
                            while ($row = mysqli_fetch_assoc($resultado2)) {
                                echo "<tr>";
                                echo "<td style='text-align: left;'><i>{$row['DescripcionUnidadDocumental']}</i></td>";
                                echo "<td style='text-align: center;'>{$row['NoFolioInicio']}</td>";
                                echo "<td style='text-align: center;'>{$row['NoFolioFin']}</td>";
                                echo "<td style='text-align: center;'>{$row['Soporte']}</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </table>
                </div>


                </td>
                </tr>

            <?php } ?>
        </tbody>
    </table>
</div>

<script>
function searchTable() {
    const input = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr'); // Selecciona todas las filas, incluidas las del acordeón.

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        let match = false;

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(input)) {
                match = true;
            }
        });

        // Muestra la fila si coincide, incluso si es parte del acordeón.
        if (match) {
            row.style.display = '';
            // Si la fila es un acordeón (clase "panel"), mostramos también su fila anterior (la principal).
            if (row.classList.contains('panel')) {
                const previousRow = row.previousElementSibling;
                if (previousRow) {
                    previousRow.style.display = ''; // Muestra la fila principal del acordeón.
                }
            }
        } else {
            row.style.display = 'none';
        }
    });
}

// Manejar acordeón
document.querySelectorAll('.accordion').forEach(button => {
    button.addEventListener('click', function() {
        const panel = this.closest('tr').nextElementSibling;
        panel.style.display = (panel.style.display === 'table-row') ? 'none' : 'table-row';
    });
});
</script>

</body>
</html>
