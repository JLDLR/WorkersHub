<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB - NUEVA TAREA</title>
  <link rel="stylesheet" href="estilos_workershub2.css">
</head>
<body>
  <?php
  include_once "ORMWorkersHub.php";

  if(!isset($_POST["guardar-tarea"])){
    echo
    "
    <form class=\"nueva_tarea_form\" method=\"POST\" action=\"nueva_tarea.php\">
      <label for=\"titulo\">Título:</label>
      <input type=\"text\" name=\"titulo\" required>
      <br>
      <label for=\"titulo\">Descripción:</label>
      <textarea name=\"descripcion\" id=\"descripcion\" rows=\"4\" cols=\"50\" required></textarea>
      <br>
      <label for=\"fecha-entrega\">Fecha de entrega:</label>
      <input type=\"date\" name=\"fecha-entrega\" id=\"fecha-entrega\" required>
      <br>
      <button type=\"submit\" name=\"guardar-tarea\">Guardar tarea</button>
    </form>
    ";
    echo "<br><a class=\"link_return_newtask\" href=\"index.php\">Volver al índice</a>";
  }elseif(isset($_COOKIE["num_usuario"]) && isset($_POST["guardar-tarea"])){
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha_entrega = $_POST["fecha-entrega"];
    $usuario = $_COOKIE["num_usuario"];
    crear_tarea($usuario, $titulo, $descripcion, $fecha_entrega);
    echo "<p>Tarea guardada con éxito.</p>";
    echo
    "
    <form class=\"nueva_tarea_form\" method=\"POST\" action=\"nueva_tarea.php\">
      <label for=\"titulo\">Título:</label>
      <input type=\"text\" name=\"titulo\" required>
      <br>
      <label for=\"titulo\">Descripción:</label>
      <textarea name=\"descripcion\" id=\"descripcion\" rows=\"4\" cols=\"50\" required></textarea>
      <br>
      <label for=\"fecha-entrega\">Fecha de entrega:</label>
      <input type=\"date\" name=\"fecha-entrega\" id=\"fecha-entrega\" required>
      <br>
      <button type=\"submit\" name=\"guardar-tarea\">Guardar tarea</button>
    </form>
    ";
    echo "<br><a href=\"index.php\">Volver al índice</a>";
  }
  ?>
  <script>
  
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1;
  var yyyy = today.getFullYear();
  if(dd<10){
    dd='0'+dd
  } 
  if(mm<10){
    mm='0'+mm
  } 

  today = yyyy+'-'+mm+'-'+dd;
  document.getElementById("fecha-entrega").setAttribute("min", today);

  </script>
</body>
</html>