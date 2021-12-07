<?php
    class Usuario{
      public $num_usuario;
      public $image_path;
      public $nombre;
      public $cargo;
      public $telefono;
      public $email;
      public $delegacion;
    }
    class Tarea{
      public $titulo;
      public $descripcion;
      public $fecha_entrega;
      public $id_tarea;
      public $estado;
      public $num_usuario;
    }
    class PeriodoVacacional{
      public $num_usuario;
      public $fecha_inicio;
      public $fecha_fin;
    }
    function obtener_perfil($num_usuario){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "SELECT num_usuario, image_path, nombre, cargo, telefono, email, delegacion FROM tabla_usuarios WHERE num_usuario = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $num_usuario);
      $stmt->execute();
      $result = $stmt->get_result();
      $usuario = null;
      if($result->num_rows > 0){
        $usuario = $result->fetch_object("Usuario");
      }
      $stmt->close();
      $conn->close();

      // $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      // $sql = "SELECT genero FROM tabla_usuarios WHERE nombre = ?";
      // $stmt = $conn->prepare($sql);
      // $stmt->bind_param("s", $nombre_usuario);
      // $stmt->execute();
      // $result = $stmt->get_result();
      // $genero = null;
      // if($result->num_rows > 0){
      //   $genero = $result->fetch_row()[0];
      //   $usuario->genero = $genero;
      // }
      // $stmt->close();
      // $conn->close();

      return $usuario;
    }
    function empleados_por_delegacion($delegacion){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      if($delegacion == "todas"){
        $sql = "SELECT num_usuario, image_path, nombre, cargo, telefono, email, delegacion FROM tabla_usuarios";
        $stmt = $conn->prepare($sql);
      }else{
        $sql = "SELECT num_usuario, image_path, nombre, cargo, telefono, email, delegacion FROM tabla_usuarios WHERE delegacion = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $delegacion);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      $empleados = [];
      if($result->num_rows > 0){
        while($row = $result->fetch_object("Usuario")) {
          array_push($empleados, $row);
        }
      }
      $stmt->close();
      $conn->close();
      return $empleados;
    }
    function mostrar_tareas($num_usuario, $opcion){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      if($opcion == "incompleta"){
        $sql = "SELECT titulo, descripcion, fecha_entrega, id_tarea, estado FROM tabla_tareas WHERE num_usuario = ? AND estado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $num_usuario, $opcion);
        $stmt->execute();
        $result = $stmt->get_result();
        $tareas = [];
        if($result->num_rows > 0){
          while($row = $result->fetch_object("Tarea")) {
            array_push($tareas, $row);
          }
        }
        $stmt->close();
        $conn->close();
        return $tareas;
      }elseif($opcion == "completa"){
        $sql = "SELECT titulo, descripcion, fecha_entrega, id_tarea, estado FROM tabla_tareas WHERE num_usuario = ? AND estado = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $num_usuario, $opcion);
        $stmt->execute();
        $result = $stmt->get_result();
        $tareas = [];
        if($result->num_rows > 0){
          while($row = $result->fetch_object("Tarea")) {
            array_push($tareas, $row);
          }
        }
        $stmt->close();
        $conn->close();
        return $tareas;
      }else{
        $sql = "SELECT titulo, descripcion, fecha_entrega, id_tarea, estado FROM tabla_tareas WHERE num_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $num_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $tareas = [];
        if($result->num_rows > 0){
          while($row = $result->fetch_object("Tarea")) {
            array_push($tareas, $row);
          }
        }
        $stmt->close();
        $conn->close();
        return $tareas;
      }
    }
    function mostrar_una_tarea($id_tarea){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "SELECT titulo, descripcion, fecha_entrega, id_tarea, estado FROM tabla_tareas WHERE id_tarea = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id_tarea);
      $stmt->execute();
      $result = $stmt->get_result();
      $tarea = null;
      if ($result->num_rows > 0) {
        $tarea = $result->fetch_object("Tarea");
      }
      $stmt->close();            
      $conn->close();
      return $tarea;
    }
    function alterar_estado($id_tarea, $nuevo_estado){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "UPDATE tabla_tareas SET estado= ? WHERE id_tarea = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si", $nuevo_estado, $id_tarea);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    }
    function crear_tarea($num_usuario, $titulo, $descripcion, $fecha_entrega){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "INSERT INTO tabla_tareas(num_usuario, titulo, descripcion, fecha_entrega) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("isss", $num_usuario, $titulo, $descripcion, $fecha_entrega);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    }
    function eliminar_tarea($id_tarea, $num_usuario){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "DELETE FROM tabla_tareas WHERE id_tarea = ? AND num_usuario = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $id_tarea, $num_usuario);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    }
    function crear_reserva($num_usuario, $inicio_periodo, $final_periodo){
      $db_servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $db_name = "bbdd_workershub";
      $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
      $sql = "INSERT INTO tabla_vacaciones(num_usuario, inicio_periodo, fin_periodo) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("iss", $num_usuario, $inicio_periodo, $fin_periodo);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    }
    ?>