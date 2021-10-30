<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB-REGISTRO  DE USUARIOS</title>
  <link rel="stylesheet" href="estilos_workershub.css">
</head>
<body>
  <?php
    //Bloque de funciones
    function registrar_usuario($nombre, $contrasenna, $cargo, $telefono, $email, $isAdmin){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_usuarios";

        $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
        $sql = "INSERT INTO tabla_usuarios(nombre, contraseña, cargo, telefono, email, isAdmin) VALUES(?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $nombre, $contrasenna, $cargo, $telefono, $email, $isAdmin);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }
    //Bloque de documento
    echo
    "
    <form method=\"POST\" action=\"register.php\">
      <label for=\"nombre\">Nombre:</label>
      <input type=\"text\" name=\"nombre\" id=\"nombre\" required>
      <br>
      <label for=\"contrasenna\">Contraseña:</label>
      <input type=\"password\" name=\"contrasenna\" id=\"contrasenna\" required>
      <br>
      <label for=\"cargo\">Cargo:</label>
      <input type=\"date\" name=\"cargo\" id=\"cargo\" required>
      <br>
      <label for=\"telefono\">telefono:</label>
      <input type=\"text\" name=\"telefono\" id=\"telefono\" required>
      <br>
      <label for=\"email\">E-Mail:</label><br>
      <textarea name=\"email\" id=\"email\" rows=\"4\" cols=\"50\" required></textarea>
      <br>
      <label for=\"isAdmin\">¿Es este usuario administrador?</label><br>
      <input type=\"checkbox\" name=\"isAdmin\" id=\"isAdmin\">
      <br>
      <button type=\"submit\" name=\"registrar_usuario\">Registrar usuario</button>
    </form>
    ";
    //Bloque de logica
    if(isset($_POST["registrarme"])){
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