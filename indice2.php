<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reordenar Capítulos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th:nth-child(1) { width: 5%; } /* Columna para mover */
        th:nth-child(2) { width: 75%; } /* Descripción */
        th:nth-child(3), th:nth-child(4) { width: 10%; } /* Inicio y Final */
        tr {
            cursor: default; /* Cambiar el cursor por defecto en las filas */
        }
        .highlight {
            background-color: #f0f0f0;
        }
        form {
            text-align: center;
            margin: 20px;
        }
        .form-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px; /* Espaciado entre elementos */
        }
        #ultimaPagina {
            font-weight: bold;
        }
        .drag-icon {
            cursor: move; /* Cambiar el cursor al mover solo en el ícono */
            width: 20px; /* Ancho del ícono */
            height: 20px; /* Alto del ícono */
        }
        .drag-column {
            cursor: move; /* Cambiar el cursor al mover en la celda de mover */
        }
        .etiquetas {
            margin: 10px 0; /* Margen para las etiquetas */
        }
    </style>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>

<!-- Sección de selección de etiquetas -->
<div class="etiquetas">
    <h3>Selecciona una etiqueta:</h3>
    <label><input type="radio" name="etiqueta" value="correspondencia"> Correspondencia</label>
    <label><input type="radio" name="etiqueta" value="acuerdos"> Acuerdos</label>
    <label><input type="radio" name="etiqueta" value="resoluciones"> Resoluciones</label>
    <label><input type="radio" name="etiqueta" value="actas"> Actas</label>
    <label><input type="radio" name="etiqueta" value="constancias"> Constancias</label>
    <label><input type="radio" name="etiqueta" value="certificaciones"> Certificaciones</label>
    <label><input type="radio" name="etiqueta" value="listados"> Listados</label>
    <label><input type="radio" name="etiqueta" value="proposiciones"> Proposiciones</label>
</div>

<table id="capitulosTable">
    <thead>
        <tr>
            <th></th> <!-- Columna para mover -->
            <th>Descripción</th>
            <th>Inicio</th>
            <th>Final</th>
            <th>Acciones</th> <!-- Nueva columna para acciones -->
        </tr>
    </thead>
    <tbody>
        <!-- Las filas de capítulos se agregarán aquí -->
    </tbody>
</table>

<form id="capituloForm">
    <h2>Agregar Folios</h2>    
    <input type="text" id="titulo" placeholder="Describir" required style="width: 80%; height: 40px; font-size: 16px;"> 
    <div class="form-row">
        <p id="ultimaPagina"></p> <!-- Para mostrar la última página -->      
        <input type="number" id="paginaFinal" placeholder="Página de Finalización" required>
        <button type="submit">Agregar Folios</button>
    </div>
</form>

<script>
$(document).ready(function() {
    let siguientePagina = 1; // Inicializar la siguiente página disponible

    // Función para agregar un nuevo capítulo
    $("#capituloForm").submit(function(event) {
        event.preventDefault(); // Evitar el envío del formulario

        // Verificar que se ha seleccionado una etiqueta
        const etiquetaSeleccionada = $("input[name='etiqueta']:checked").val();
        if (!etiquetaSeleccionada) {
            alert("Por favor, selecciona una etiqueta antes de agregar un capítulo.");
            return;
        }

        // Obtener el título y la página final del formulario
        const titulo = $("#titulo").val();
        const paginaFinal = parseInt($("#paginaFinal").val());

        // Calcular la página de inicio
        const paginaInicio = siguientePagina;

        // Si la página final es menor que la página de inicio, no agregar el capítulo
        if (paginaFinal < paginaInicio) {
            alert("La página de finalización debe ser igual o mayor que la página de inicio.");
            return;
        }

        // Calcular el número de páginas
        const numPaginas = paginaFinal - paginaInicio + 1;

        // Agregar la nueva fila a la tabla al final
        $("#capitulosTable tbody").append(`
            <tr data-num-paginas="${numPaginas}">
                <td class="drag-column"><span class="drag-icon">&#x21D5;</span></td> <!-- Ícono de arrastre -->
                <td contenteditable="true" class="editable">${etiquetaSeleccionada}: ${titulo}</td>
                <td>${paginaInicio}</td>
                <td>${paginaFinal}</td>
                <td><button class="eliminar">Eliminar</button></td> <!-- Botón para eliminar -->
            </tr>
        `);

        // Limpiar el campo de título y la página final, pero mantener la selección de etiqueta
        $("#titulo").val('');
        $("#paginaFinal").val('');

        // Actualizar el orden de las filas
        actualizarPaginas();
    });

    // Hacer que las filas de la tabla sean reordenables
    $("#capitulosTable tbody").sortable({
        items: "tr",
        cursor: "move",
        placeholder: "highlight",
        handle: ".drag-icon", // Hacer que el arrastre funcione solo desde la columna del ícono
        update: function(event, ui) {
            // Actualizar el orden de las páginas al mover filas
            actualizarPaginas();
        }
    });
    $("#capitulosTable tbody").disableSelection(); // Desactiva la selección de texto

    // Función para actualizar los números de las páginas
    function actualizarPaginas() {
        // Resetear la siguiente página disponible
        siguientePagina = 1; // Volver a la página inicial

        $("#capitulosTable tbody tr").each(function() {
            const $fila = $(this);
            const numPaginas = parseInt($fila.data("num-paginas")); // Obtener el número de páginas del capítulo

            // Actualizar la página de inicio y finalización basándonos en la siguiente página
            const nuevaPaginaInicio = siguientePagina;
            const nuevaPaginaFinal = siguientePagina + numPaginas - 1; // Calcular la página final

            // Actualizar los valores de las páginas
            $fila.find("td:eq(2)").text(nuevaPaginaInicio); // Actualizar página de inicio
            $fila.find("td:eq(3)").text(nuevaPaginaFinal); // Actualizar página de finalización

            // Actualizar la siguiente página disponible
            siguientePagina = nuevaPaginaFinal + 1; // La siguiente página inicia después de la página final actual
        });

        // Mostrar la última página del último capítulo
        $("#ultimaPagina").text(`Folio: ${siguientePagina}`); // Mostrar el último folio
    }

    // Función para eliminar una fila
    $(document).on("click", ".eliminar", function() {
        const $fila = $(this).closest("tr");
        const confirmar = confirm("¿Está seguro de que desea eliminar este capítulo?");
        if (confirmar) {
            $fila.remove(); // Eliminar la fila
            actualizarPaginas(); // Actualizar números de páginas después de eliminar
        }
    });

    // Permitir la edición del título y guardar cambios
    $(document).on("blur", ".editable", function() {
        const nuevoTitulo = $(this).text();
        if (nuevoTitulo.trim() === "") {
            alert("El título no puede estar vacío.");
            $(this).text("Título"); // Restaurar el texto a un valor por defecto
        }
    });
});
</script>

</body>
</html>
