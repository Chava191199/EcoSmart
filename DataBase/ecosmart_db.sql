-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2026 a las 04:41:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
DROP DATABASE IF EXISTS `ecosmart_db`;
CREATE DATABASE IF NOT EXISTS `ecosmart_db`;
use `ecosmart_db`;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ecosmart_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo_energetico`
--

CREATE TABLE `consumo_energetico` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `consumo` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reciclaje`
--

CREATE TABLE `reciclaje` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('admin','usuario') DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `fecha_registro`, `foto`) VALUES
(1, 'Hector del Toro', 'hector@gmail.com', '$2y$10$2YFo7cfop4oPQcSjfh2SnuB8qCmbE9ab9LIyJ9f9Z900Tn98DHh2C', 'admin', '2026-05-27 00:37:48', 'default.png'),
(2, 'Administrador', 'admin@ecosmart.com', '0192023a7bbd73250516f069df18b500', 'admin', '2026-05-30 21:09:51', 'default.png'),
(3, 'christian refugio', 'christian@gmail.com', '71be294746389f836c26e7963ee52178', 'usuario', '2026-05-30 22:23:39', 'default.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consumo_energetico`
--
ALTER TABLE `consumo_energetico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `reciclaje`
--
ALTER TABLE `reciclaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consumo_energetico`
--
ALTER TABLE `consumo_energetico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reciclaje`
--
ALTER TABLE `reciclaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumo_energetico`
--
ALTER TABLE `consumo_energetico`
  ADD CONSTRAINT `consumo_energetico_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reciclaje`
--
ALTER TABLE `reciclaje`
  ADD CONSTRAINT `reciclaje_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
