<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB - DIRECTORIO</title>
  <link rel="stylesheet" href="estilos_workershub2.css">
</head>
<body>
<?php
    include_once 'ORMWorkersHub.php';

    if(!isset($_POST["mostrardelegaciones"])){
        echo
        "
        <div class=\"contenedor-selector-directorio\">
        <form method=\"POST\" action=\"directorio.php\">
        <select name=\"opciondelegaciones\" id=\"opciondelegaciones\" required>
          <option value=\"todas\" selected>Todas las delegaciones</option>
          <option value=\"madrid\">Madrid</option>
          <option value=\"barcelona\">Barcelona</option>
          <option value=\"sevilla\">Sevilla</option>
          <option value=\"malaga\">Málaga</option>
          <option value=\"valencia\">Valencia</option>
          <option value=\"bilbao\">Bilbao</option>
        </select>
        <button type=\"submit\" name=\"mostrardelegaciones\">Mostrar empleados</button>
        </form>
        <a href=\"index.php\">Volver al índice</a>
        </div>
        ";
    }else{
        $opcion = $_POST["opciondelegaciones"];
        $empleados = null;
        $empleados = empleados_por_delegacion($opcion);
        if(isset($empleados)){
            echo "<a class=\"enlace-directorio-retorno\" href=\"directorio.php\">Selección de directorio</a>";
            echo
            "
            <table class=\"tabla-empleados\">
            <tr>
                <th></th><th>Nombre</th><th>Cargo</th><th>Telefono</th><th>E-Mail</th><th>Delegación</th>
            </tr>
            ";
            foreach ($empleados as $indice => $empleado) {
                echo
                "
                <tr>
                    <td><img src=\"".$empleado->image_path."\"></td>
                    <td>".$empleado->nombre."</td>
                    <td>".$empleado->cargo."</td>
                    <td>".$empleado->telefono."</td>
                    <td>".$empleado->email."</td>
                    <td>".$empleado->delegacion."</td>
                </tr>
                ";
            }
            echo
            "
            </table>
            ";
        }
    }
?>
</body>
</html>