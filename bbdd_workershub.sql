-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-12-2021 a las 11:18:49
-- Versión del servidor: 10.4.10-MariaDB
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bbdd_workershub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_registros_horarios`
--

CREATE TABLE `tabla_registros_horarios` (
  `num_usuario` int(255) NOT NULL,
  `dia_del_mes` date NOT NULL,
  `inicio_jornada` varchar(30) NOT NULL,
  `fin_jornada` varchar(30) NOT NULL,
  `horas_jornada` int(30) NOT NULL,
  `tiempo_comida` int(30) NOT NULL,
  `tiempo_descansos` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tabla_registros_horarios`
--

INSERT INTO `tabla_registros_horarios` (`num_usuario`, `dia_del_mes`, `inicio_jornada`, `fin_jornada`, `horas_jornada`, `tiempo_comida`, `tiempo_descansos`) VALUES
(4, '2007-12-21', '06:01:51pm', '', 0, 0, 0),
(4, '2009-12-21', '10:37:52am', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_tareas`
--

CREATE TABLE `tabla_tareas` (
  `id_tarea` int(6) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `estado` varchar(12) NOT NULL DEFAULT 'incompleta',
  `fecha_entrega` date NOT NULL,
  `num_usuario` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_usuarios`
--

CREATE TABLE `tabla_usuarios` (
  `num_usuario` int(6) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `contrasenna` varchar(30) NOT NULL,
  `cargo` varchar(30) NOT NULL,
  `telefono` int(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `delegacion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tabla_usuarios`
--

INSERT INTO `tabla_usuarios` (`num_usuario`, `image_path`, `nombre`, `contrasenna`, `cargo`, `telefono`, `email`, `delegacion`) VALUES
(4, 'images\\profile_pictures\\15871678_1202054046552505_1579375580444360013_n.jpg', 'Jose Luis Linares del Rio', 'a1234b', 'Administrador', 555555555, 'danzig.wolf@hotmail.com', 'Madrid'),
(5, '', 'Elena Sánchez Ortiz', 'e1234so', 'CEO', 555555555, 'elenasanchezortiz@gmail.com', 'Madrid'),
(6, '', 'Francisco Gutiérrez Olea', 'f1234go', 'Administrativo', 555555555, 'franciscogutierrezolea@gmail.com', 'Barcelona');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tabla_registros_horarios`
--
ALTER TABLE `tabla_registros_horarios`
  ADD PRIMARY KEY (`dia_del_mes`);

--
-- Indices de la tabla `tabla_tareas`
--
ALTER TABLE `tabla_tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `num_usuario` (`num_usuario`);

--
-- Indices de la tabla `tabla_usuarios`
--
ALTER TABLE `tabla_usuarios`
  ADD PRIMARY KEY (`num_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tabla_tareas`
--
ALTER TABLE `tabla_tareas`
  MODIFY `id_tarea` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tabla_usuarios`
--
ALTER TABLE `tabla_usuarios`
  MODIFY `num_usuario` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tabla_tareas`
--
ALTER TABLE `tabla_tareas`
  ADD CONSTRAINT `tabla_tareas_ibfk_1` FOREIGN KEY (`num_usuario`) REFERENCES `tabla_usuarios` (`num_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
