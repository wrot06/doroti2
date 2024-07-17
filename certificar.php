<!DOCTYPE html>

<html lang="es">

<?php   require 'rene/head.php';  ?>
   <style>
        .sapam {
            border: 2px solid #ccc;
            padding: 10px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            margin: 20px; /* Agregamos margen para dar espacio alrededor del contenido */
        }

        .sapam p:first-child {
            font-weight: bold;
        }

        .sapam a {
            color: #007BFF;
            text-decoration: none;
        }

        .sapam a:hover {
            text-decoration: underline;
        }

        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
          }
        input[type=number] { -moz-appearance:textfield; }
          
          
        input[type=date]::-webkit-inner-spin-button, 
        input[type=date]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
          }
        input[type=date] { -moz-appearance:textfield; }
    </style>


<body data-spy="scroll" data-target="#navbar" class="static-layout"><br><br>

<center><img src="img/logo.png" style="width: 400px;"><br><br></center>

    <div class="title-wrap">

    <br><h3>X Congreso Internacional de Derecho Constitucional</h3>
    <p>Para generar tu certificado digital, escribe tu número de Identificación y clic en Generar Certificado</p>
    <p class="p1" style="font-size: 11px;">NOTA: Por favor, habilita la opción de permitir ventanas emergentes en tu navegador.<p>

                    <form method="GET" action="consulta.php"  required>

                        <div class="row">
                            <div class="col-md-12 form-group">
                                <center>
                                <input autoFocus style="width: 250px; font-size: 20px; padding: 10px; margin: 0 auto; text-align: center; " type="number" class="form-control" id="nombre" name="id" placeholder="Número de identificación" onkeydown="filtro()" min="100000" max="99999999999" size="10" required>
                            </div>
                            <br>
                            <div class="col-md-12 text-center">
                                <button style="background-color: #009640; margin-right: 10px; font-size: 20px;" class="btn btn-primary btn-shadow btn-lg" type="submit" name="submit">Generar Certificado</button>

                            </div>
                        </div>
                    </form>

</div>

<div class="sapam" style="width: 400px; margin: 0 auto; margin-top: 10px;">
    <p>Actualización: Descarga de Certificados del X Congreso de Derecho Constitucional</p>
    <p>Estimados asistentes al X Congreso de Derecho Constitucional,</p>
    <p>Hemos actualizado nuestra página web y trasladado los certificados de asistencia a uno de nuestros servidores para mayor seguridad. Ahora, pueden descargar sus certificados actualizados desde nuestra página oficial: <a href="https://ciesju.udenar.edu.co/app/certificar.php" target="_blank">ciesju.udenar.edu.co/app/certificar.php</a></p>
    <p>Atentamente,</p>
    <p>WHATHSON RENE ORDOÑEZ TORRES<br>Auxiliar Administrativo</p>
</div>






                