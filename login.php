<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB-LOGIN</title>
  <link rel="stylesheet" href="estilos_workershub2.css">
</head>
<body>
  <?php

    class UsuarioLogin{
      public $num_usuario;
      public $nombre;
      public $contrasenna;
      public $cargo;
    }

    //Bloque de funciones
    function validar_conexion($nombre_aportado, $contrasenna_aportada){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "SELECT num_usuario, nombre, contrasenna, cargo FROM tabla_usuarios WHERE nombre = ? AND contrasenna = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $nombre_aportado, $contrasenna_aportada);
      $stmt->execute();
      $result = $stmt->get_result();
      $usuarioLogin = null;
      if($result->num_rows > 0){
        $usuarioLogin = $result->fetch_object("UsuarioLogin");
        $stmt->close();
        $conn->close();
        return $usuarioLogin;
      }else{
        $stmt->close();
        $conn->close();
        return false;
      }
    }
    //Bloque de documento
    echo
    "
    <div class=\"contenedor-form-login\">
      <form method=\"POST\" action=\"login.php\">
        <label for=\"nombre_aportado\">Nombre de usuario:</label>
        <input type=\"text\" name=\"nombre_aportado\" id=\"nombre_aportado\" required><br>
        <label for\"contrasenna_aportada\">Contraseña:</label>
        <input type=\"password\" name=\"contrasenna_aportada\" id=\"contrasenna_aportada\" required><br>
        <button type=\"submit\" name=\"conectarme\">Conectarse</button>
      </form>
      <br>
      <form method=\"POST\" id=\"form-boton-registro\" action=\"register.php\">
        <button type=\"submit\">Registrarse</button>
      </form>
    </div>
    ";
    //Bloque de logica
    if(isset($_POST["conectarme"])){
      $nombre = $_POST["nombre_aportado"];
      $contrasenna = $_POST["contrasenna_aportada"];
      $usuarioLogin = validar_conexion($nombre, $contrasenna);
      if ($usuarioLogin) {
        setcookie("num_usuario", $usuarioLogin->num_usuario, time() + (86400 * 0.25), "/");
        setcookie("cargo", $usuarioLogin->cargo, time() + (86400 * 0-25), "/");
        header("Location: index.php");
      }else{
        echo "Este usuario no existe o la contraseña introducida es erronea.";
      }
    }
  ?>
</body>
</html>