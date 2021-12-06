<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB-REGISTRO  DE USUARIOS</title>
  <link rel="stylesheet" href="estilos_workershub2.css">
</head>
<body>
  <?php
    //Bloque de funciones
    function registrar_usuario($nombre, $contrasenna, $cargo, $telefono, $email){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";

        $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
        $sql = "INSERT INTO tabla_usuarios(nombre, contraseña, cargo, telefono, email) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $nombre, $contrasenna, $cargo, $telefono, $email);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
    //Bloque de documento
    echo
    "
    <form method=\"POST\" id=\"form-registro\" action=\"register.php\">
      <label for=\"nombre\">Nombre:</label>
      <input type=\"text\" name=\"nombre\" id=\"nombre\" required>
      <br>
      <label for=\"contrasenna\">Contraseña:</label>
      <input type=\"password\" name=\"contrasenna\" id=\"contrasenna\" required>
      <br>
      <label for=\"cargo\">Cargo:</label>
      <input type=\"text\" name=\"cargo\" id=\"cargo\" required>
      <br>
      <label for=\"telefono\">Teléfono:</label>
      <input type=\"text\" name=\"telefono\" id=\"telefono\" required>
      <br>
      <label for=\"email\">E-Mail:</label><br>
      <input type=\"email\" name=\"email\" id=\"email\" required>
      <br>
      <button type=\"submit\" name=\"registrar_usuario\">Registrar usuario</button>
    </form>

    <a id=\"register-return\" href=\"index.php\">Volver al índice</a>
    ";
    //Bloque de logica
    if(isset($_POST["registrar_usuario"])){
      $nombre = $_POST["nombre"];
      $contrasenna = $_POST["contrasenna"];
      $cargo = $_POST["cargo"];
      $email = $_POST["email"];
      $telefono = $_POST["telefono"];
      registrar_usuario($nombre, $contrasenna, $cargo, $telefono, $email);
    }
  ?>
</body>
</html>