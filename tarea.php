<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB - VISUALIZAR TAREA</title>
  <link rel="stylesheet" href="estilos_workershub.css">
</head>
<body>
<?php
include_once 'ORMWorkersHub.php';

echo "<a href=\"index.php\">Volver al índice</a><br>";

if(isset($_POST["vertarea"])){
  echo "<br>";
  echo "Título: ".$_POST["titulo-de-tarea"];
  echo "<br>";
  echo "Descripción: ".$_POST["descripcion-de-tarea"];
  if($_POST["estado"] == "incompleta"){
    echo
    "
    <form method=\"POST\" action=\"tarea.php\">
    <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$_POST["id_tarea"]."\">
    <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"completa\">
    <button type=\"submit\" name=\"cambio-de-estado\">Completada (Confirmar)</button>
    </form>
    ";
  }else{
    echo
    "
    <form method=\"POST\" action=\"tarea.php\">
    <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$_POST["id_tarea"]."\">
    <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"incompleta\">
    <button type=\"submit\" name=\"cambio-de-estado\">Incompleta (Confirmar)</button>
    ";
  }
}elseif(isset($_POST["cambio-de-estado"])){
  $id_tarea = $_POST["id-de-tarea"];
  $nuevo_estado = $_POST["nuevo-estado"];
  alterar_estado($id_tarea, $nuevo_estado);
  $tarea = mostrar_una_tarea($id_tarea);
  echo $tarea->titulo;
  echo "<br>";
  echo $tarea->descripcion;
  if($tarea->estado == "incompleta"){
    echo
    "
    <form method=\"POST\" action=\"tarea.php\">
    <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
    <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"completa\">
    <button type=\"submit\" name=\"cambio-de-estado\">Completada (Confirmar)</button>
    </form>
    ";
  }else{
    echo
    "
    <form method=\"POST\" action=\"tarea.php\">
    <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
    <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"incompleta\">
    <button type=\"submit\" name=\"cambio-de-estado\">Incompleta (Confirmar)</button>
    ";
  }
}
?>
</body>
</html>