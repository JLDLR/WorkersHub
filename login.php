<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB-LOGIN</title>
  <link rel="stylesheet" href="estilos_workershub.css">
</head>
<body>
  <?php
    //Bloque de funciones
    function validar_conexion($nombre_aportado, $contrasenna_aportada){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "SELECT nombre, contrasenna FROM tabla_usuarios WHERE nombre = ? AND contrasenna = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $nombre_aportado, $contrasenna_aportada);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0){
        return true;
      }else{
        return false;
      }
      $stmt->close();
      $conn->close();
    }
    //Bloque de documento
    echo
    "
    <form method=\"POST\" action=\"login.php\">
      <label for=\"nombre_aportado\">Nombre de usuario:</label>
      <input type=\"text\" name=\"nombre_aportado\" id=\"nombre_aportado\" required><br>
      <label for\"contrasenna_aportada\">Contraseña:</label>
      <input type=\"password\" name=\"contrasenna_aportada\" id=\"contrasenna_aportada\" required><br>
      <button type=\"submit\" name=\"conectarme\">Conectarse</button>
    </form>

    <br>

    <form method=\"POST\" action=\"register.php\">
      <button type=\"submit\">Registrarse</button>
    </form>
    ";
    //Bloque de logica
    if(isset($_POST["conectarme"])){
      $nombre = $_POST["nombre_aportado"];
      $contrasenna = $_POST["contrasenna_aportada"];
      if( validar_conexion($nombre, $contrasenna) ){
        setcookie("nombre_usuario", $_POST["nombre_aportado"], time() + (86400 * 30), "/");
        header("Location: index.php");
      }
    }
  ?>
</body>
</html>