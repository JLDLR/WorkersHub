<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WORKERHUB - INDICE</title>
  <link rel="stylesheet" href="estilos_workershub2.css">
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
      <form method=\"POST\" id=\"form-boton-login\" action=\"login.php\">
      <button type=\"submit\" id=\"login\">Log-In</button>
      </form>
      ";
    }elseif( isset($_POST["iniciar_jornada"]) && isset($_COOKIE["num_usuario"]) ){
      $num_usuario = $_COOKIE["num_usuario"];
      registrar_inicio_jornada($num_usuario);

      echo "<div class=\"contenedor-botonera-indice-logged\">";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"verperfil\">Ver perfil</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"directorio.php\">
      <button type=\"submit\" name=\"verdirectorio\">Consultar directorio</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" id=\"form-indice-accion-mostrar-tareas\" action=\"index.php\">
      <button type=\"submit\" name=\"mostrartareas\">Mostrar tareas</button>
      <select name=\"opciontareas\" class=\"selector-mostrar-tareas\" id=\"opciontareas\" required>
        <option value=\"todas\" selected>Todas las tareas</option>
        <option value=\"incompleta\">Tareas incompletas</option>
        <option value=\"completa\">Tareas completas</option>
      </select>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <input type=\"text\" name=\"fin-jornada\" id=\"fin-jornada\" class=\"invisible\">
      <button type=\"submit\" name=\"finalizar_jornada\">Finalizar jornada</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"logout\">Desconectarme</button>
      </form>
      ";
      echo "</div>";
    }elseif(isset($_COOKIE["num_usuario"]) && isset($_POST["borrado_de_tarea"])){
      //Si al entrar al indice hemos tomado la decisi??n de borrar la tarea, ejecutamos el borrado y volvemos a mostrar la botonera de inicio.
      $id_tarea = $_POST["id-de-tarea"];
      $num_usuario = $_COOKIE["num_usuario"];
      eliminar_tarea($id_tarea, $num_usuario);
      echo "Tarea eliminada.";
      echo "<div class=\"contenedor-botonera-indice-logged\">";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"verperfil\">Ver perfil</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"directorio.php\">
      <button type=\"submit\" name=\"verdirectorio\">Consultar directorio</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" id=\"form-indice-accion-mostrar-tareas\" action=\"index.php\">
      <button type=\"submit\" name=\"mostrartareas\">Mostrar tareas</button>
      <select name=\"opciontareas\" class=\"selector-mostrar-tareas\" id=\"opciontareas\" required>
        <option value=\"todas\" selected>Todas las tareas</option>
        <option value=\"incompleta\">Tareas incompletas</option>
        <option value=\"completa\">Tareas completas</option>
      </select>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"logout\">Desconectarme</button>
      </form>
      ";
      echo "</div>";
    }elseif(isset($_COOKIE["num_usuario"]) && !isset($_POST["verperfil"]) && !isset($_POST["mostrartareas"]) && !isset($_POST["cambio-de-estado"])){
      //Si cuando entramos a index.php existe la cookie de nombre de usuario pero no se ha tomado ninguna acci??n, mostramos los necesarios.
      echo "<div class=\"contenedor-botonera-indice-logged\">";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"verperfil\">Ver perfil</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"directorio.php\">
      <button type=\"submit\" name=\"verdirectorio\">Consultar directorio</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" id=\"form-indice-accion-mostrar-tareas\" action=\"index.php\">
      <button type=\"submit\" name=\"mostrartareas\">Mostrar tareas</button>
      <select name=\"opciontareas\" class=\"selector-mostrar-tareas\" id=\"opciontareas\" required>
        <option value=\"todas\" selected>Todas las tareas</option>
        <option value=\"incompleta\">Tareas incompletas</option>
        <option value=\"completa\">Tareas completas</option>
      </select>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"iniciar_jornada\">Iniciar jornada</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"logout\">Desconectarme</button>
      </form>
      ";
      echo "</div>";
    }elseif(isset($_COOKIE["num_usuario"]) && isset($_POST["mostrartareas"]) && !isset($_POST["cambio-de-estado"])){
      //Si cuando entramos a index.php se ha tomado la decisi??n de mostrar tareas, pero no estamos marcando una tarea como completa o incompleta, entonces mostramos las tareas de usuario.
      $opcion = $_POST["opciontareas"];
      $num_usuario = $_COOKIE["num_usuario"];
      $tareas = null;
      $tareas = mostrar_tareas($num_usuario, $opcion);
      if(isset($tareas)){
        echo "<div class=\"contenedor_tareas_en_pantalla\">";
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
          //Despu??s de haber creado el bot??n de la tarea, creamos sus botones de estado de terminaci??n de la tarea y de borrado.
          if($tarea->estado == "incompleta"){
            echo
            "
            <form method=\"POST\" action=\"index.php\">
            <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
            <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"completa\">
            <button type=\"submit\" name=\"cambio-de-estado\">Completada (Confirmar)</button>
            </form>
            ";
          }else{
            echo
            "
            <form method=\"POST\" action=\"index.php\">
            <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
            <input class=\"invisible\" type=\"text\" name=\"nuevo-estado\" value=\"incompleta\">
            <button type=\"submit\" name=\"cambio-de-estado\">Incompleta (Confirmar)</button>
            </form>
            ";
          }
          echo
          "
          <form method=\"POST\" action=\"index.php\">
          <input class=\"invisible\" type=\"number\" name=\"id-de-tarea\" value=\"".$tarea->id_tarea."\">
          <button type=\"submit\" name=\"borrado_de_tarea\">Eliminar tarea</button>
          </form>
          <br>
          ";
        }
        echo "</div>";
        //Por ??ltimo, creamos el bot??n para a??adir una nueva tarea y para volver
        echo
        "
        <br>
        <form method=\"POST\" action=\"nueva_tarea.php\">
        <button id=\"boton-crear-nueva-tarea\" type=\"submit\" name=\"crear-tarea\">Crear tarea</button>
        </form>
        <br>
        <a class=\"link_return\" href=\"index.php\">Volver al ??ndice</a>
        ";
      }
    }elseif(isset($_COOKIE["num_usuario"]) && isset($_POST["cambio-de-estado"])){
      //Si cuando entramos al indice hemos tomado la decisi??n de cambiar el estado de terminaci??n de la tarea, ejecutamos el cambio y volvemos a mostrar los botones de inicio.
      $id_tarea = $_POST["id-de-tarea"];
      $nuevo_estado = $_POST["nuevo-estado"];
      alterar_estado($id_tarea, $nuevo_estado);
      echo "Estado alterado.";
      echo "<div class=\"contenedor-botonera-indice-logged\">";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"verperfil\">Ver perfil</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"directorio.php\">
      <button type=\"submit\" name=\"verdirectorio\">Consultar directorio</button>
      </form>
      ";
      echo
      "
      <form method=\"POST\" id=\"form-indice-accion-mostrar-tareas\" action=\"index.php\">
      <button type=\"submit\" name=\"mostrartareas\">Mostrar tareas</button>
      <select name=\"opciontareas\" class=\"selector-mostrar-tareas\" id=\"opciontareas\" required>
        <option value=\"todas\" selected>Todas las tareas</option>
        <option value=\"incompleta\">Tareas incompletas</option>
        <option value=\"completa\">Tareas completas</option>
      </select>
      </form>
      ";
      echo
      "
      <form method=\"POST\" action=\"index.php\">
      <button type=\"submit\" name=\"logout\">Desconectarme</button>
      </form>
      ";
      echo "</div>";

    }

    // Cuando tenemos cookie de usuario y tomamos la decisi??n de ver el perfil, lo obtenemos y sacamos por pantalla al usuario.
    if(isset($_POST["verperfil"]) && isset($_COOKIE["num_usuario"])){
      $num_usuario = $_COOKIE["num_usuario"];
      $usuario = null;
      $usuario = obtener_perfil($num_usuario);
      if(isset($usuario)){
        echo //Primer echo. Generamos la tabla junto a las cabeceras y la informaci??n de usuario obligatoria.
        "
        <table>
          <tr>
            <th></th><th>Nombre</th><th>Cargo</th><th>Telefono</th><th>E-Mail</th>
          </tr>
          <tr>
            <td><img src=\"".$usuario->image_path."\"></td>
            <td>".$usuario->nombre."</td>
            <td>".$usuario->cargo."</td>
            <td>".$usuario->telefono."</td>
            <td>".$usuario->email."</td>";
        // if($usuario->genero){ //If de control para saber si se ha especificado el g??nero para insertarlo en la tabla.
        //   echo
        //   "
        //     <td>".$usuario->genero."</td>
        //   ";
        // }
        echo //??ltimo echo para cerrar la fila de datos y la tabla.
        "
          </tr>
        </table>
        <a href=\"index.php\" class=\"boton-vuelta-indice-general\">Volver al ??ndice</a>
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