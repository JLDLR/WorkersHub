<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB - DIRECTORIO</title>
  <link rel="stylesheet" href="estilos_workershub.css">
</head>
<body>
<?php
    include_once 'ORMWorkersHub.php';

    if(!isset($_POST["mostrardelegaciones"])){
        echo
        "
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
        <button type=\"submit\" name=\"mostrardelegaciones\">Mostrar delegaciones</button>
        </form>
        ";
    }else{
        $opcion = $_POST["opciondelegaciones"];
        $empleados = null;
        $empleados = empleados_por_delegacion($opcion);
        if(isset($empleados)){
            echo
            "
            <table>
            <tr>
                <th>Nombre</th><th>Cargo</th><th>Telefono</th><th>E-Mail</th>
            </tr>
            ";
            foreach ($empleados as $indice => $empleado) {
                echo
                "
                <tr>
                    <td>".$usuario->nombre."</td>
                    <td>".$usuario->cargo."</td>
                    <td>".$usuario->telefono."</td>
                    <td>".$usuario->email."</td>
                    <td>".$usuario->delegacion."</td>
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