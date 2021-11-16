<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB - INDICE</title>
  <link rel="stylesheet" href="estilos_workershub.css">
</head>
<body>
  <?php
    //Clases
    //-----------Bloque de funciones
    include_once 'ORMWorkersHub.php';
    //-----------Bloque de documento
    if(!isset($_COOKIE["num_usuario"])){ //Si cuando entramos a index.php no existe la cookie de nombre de usuario, eso quiere decir que es nuestra primera visita.
      echo
      "
      <form method=\"POST\" action=\"login.php\">
      <button type=\"submit\">Log-In</button>
      </form>
      ";
    }elseif(isset($_COOKIE["num_usuario"]) && !isset($_POST["verperfil"]) && !isset($_POST["mostrartareas"]) && !isset($_POST["cambio-de-estado"])){
      //Si cuando entramos a index.php existe la cookie de nombre de usuario pero no se ha tomado ninguna acción, mostramos los necesarios.
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"verperfil\">Ver perfil</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" acion=\"directorio.php\">
      <button type=\"submit\" name=\"verdirectorio\"Consultar directorio</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <select name=\"opciontareas\" id=\"opciontareas\" required>
        <option value=\"todas\" selected>Todas las tareas</option>
        <option value=\"incompleta\">Tareas incompletas</option>
        <option value=\"completa\">Tareas completas</option>
      </select>
      <button type=\"submit\" name=\"mostrartareas\">Mostrar tareas</button>
      </form>
      ";
      echo "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"logout\">Desconectarme</button>
      </form>
      ";
    }elseif(isset($_COOKIE["num_usuario"]) && isset($_POST["mostrartareas"]) && !isset($_POST["cambio-de-estado"])){
      //Si cuando entramos a index.php se ha tomado la decisión de mostrar tareas, pero no estamos marcando una tarea como completa o incompleta, entonces mostramos las tareas de usuario.
      $opcion = $_POST["opciontareas"];
      $num_usuario = $_COOKIE["num_usuario"];
      $tareas = null;
      $tareas = mostrar_tareas($num_usuario, $opcion);
      if(isset($tareas)){
        foreach ($tareas as $indice => $tarea) {
          echo
          "
          <form id=\"formularioTarea\" method=\"POST\" action=\"tarea.php\">
          <input class=\"invisible\" type=\"number\" name=\"id_tarea\" value=\"".$tarea->id_tarea."\">
          <input class=\"invisible\" type=\"text\" name=\"estado\" value=\"".$tarea->estado."\">
          <input class=\"invisible\" type=\"text\" name=\"titulo-de-tarea\" value=\"".$tarea->titulo."\">
          <textarea class=\"invisible\" name=\"descripcion-de-tarea\" readonly>".$tarea->descripcion."</textarea>
          <input class=\"invisible\" type=\"text\" name=\"fecha-de-entrega\" value=\"".$tarea->fecha_entrega."\">
          <button type=\"submit\" name=\"vertarea\">".$tarea->titulo."</button>
          </form>
          ";
          //Después de haber creado el botón de la tarea, creamos sus botones de estado de terminación de la tarea.
          if($tarea->estado == "incompleta"){
            echo
            "
            <form method=\"POST\" action=\"index.php\">
            <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
            <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"completa\">
            <button type=\"submit\" name=\"cambio-de-estado\">Completada (Confirmar)</button>
            </form>
            <br>
            ";
          }else{
            echo
            "
            <form method=\"POST\" action=\"index.php\">
            <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
            <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"incompleta\">
            <button type=\"submit\" name=\"cambio-de-estado\">Incompleta (Confirmar)</button>
            </form>
            <br>
            ";
          }
        }
        //Por último, creamos el botón para añadir una nueva tarea y para volver
        echo
        "
        <br>
        <form method=\"POST\" action=\"nueva_tarea.php\">
        <button type=\"submit\" name=\"crear-tarea\">Crear tarea</button>
        </form>
        <br>
        <a href=\"index.php\">Volver al índice</a>
        ";
      }
    }elseif(isset($_COOKIE["num_usuario"]) && isset($_POST["cambio-de-estado"])){
      //Si cuando entramos al indice hemos tomado la decisión de cambiar el estado de terminación de la tarea, ejecutamos el cambio y volvemos a mostrar los botones de inicio.
      $id_tarea = $_POST["id-de-tarea"];
      $nuevo_estado = $_POST["nuevo-estado"];
      alterar_estado($id_tarea, $nuevo_estado);

      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"verperfil\">Ver perfil</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <select name=\"opciontareas\" id=\"opciontareas\" required>
        <option value=\"todas\" selected>Todas las tareas</option>
        <option value=\"incompleta\">Tareas incompletas</option>
        <option value=\"completa\">Tareas completas</option>
      </select>
      <button type=\"submit\" name=\"mostrartareas\">Mostrar tareas</button>
      </form>
      ";
    }
    // Cuando tenemos cookie de usuario y tomamos la decisión de ver el perfil, lo obtenemos y sacamos por pantalla al usuario.
    if(isset($_POST["verperfil"]) && isset($_COOKIE["num_usuario"])){
      $num_usuario = $_COOKIE["num_usuario"];
      $usuario = null;
      $usuario = obtener_perfil($num_usuario);
      if(isset($usuario)){
        echo //Primer echo. Generamos la tabla junto a las cabeceras y la información de usuario obligatoria.
        "
        <table>
          <tr>
            <th>Nombre</th><th>Cargo</th><th>Telefono</th><th>E-Mail</th>
          </tr>
          <tr>
            <td>".$usuario->nombre."</td>
            <td>".$usuario->cargo."</td>
            <td>".$usuario->telefono."</td>
            <td>".$usuario->email."</td>";
        // if($usuario->genero){ //If de control para saber si se ha especificado el género para insertarlo en la tabla.
        //   echo
        //   "
        //     <td>".$usuario->genero."</td>
        //   ";
        // }
        echo //Último echo para cerrar la fila de datos y la tabla.
        "
          </tr>
        </table>
        <a href=\"index.php\">Volver</a>
        ";
      }
    }
    //Log-out
    if(isset($_POST["logout"]) && isset($_COOKIE["num_usuario"])){
      setcookie("num_usuario", "", time() - 3600, "/");
      setcookie("cargo", "", time() - 3600, "/");
      header("Location: index.php");
    }
  ?>
</body>
</html>