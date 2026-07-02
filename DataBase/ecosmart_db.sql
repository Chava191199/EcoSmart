-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-06-2026 a las 00:01:30
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
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
-- Estructura de tabla para la tabla `consumo_agua`
--

CREATE TABLE `consumo_agua` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `consumo` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumo_agua`
--

INSERT INTO `consumo_agua` (`id`, `usuario_id`, `consumo`, `fecha`) VALUES
(1, 8, 100, '2026-06-20 23:05:06'),
(2, 8, 300, '2026-06-20 23:05:13'),
(3, 8, 1000, '2026-06-20 23:05:18'),
(4, 8, 5000, '2026-06-20 23:05:43'),
(5, 8, 8000, '2026-06-20 23:05:50'),
(6, 8, 1200, '2026-06-20 23:05:56'),
(7, 8, 12000, '2026-06-20 23:06:01');

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

--
-- Volcado de datos para la tabla `consumo_energetico`
--

INSERT INTO `consumo_energetico` (`id`, `usuario_id`, `consumo`, `fecha`) VALUES
(1, 8, 200, '2026-06-15 01:49:43'),
(2, 8, 5000, '2026-06-17 00:47:12'),
(3, 6, 5000, '2026-06-17 03:16:49'),
(4, 6, 6700, '2026-06-20 21:07:28'),
(5, 6, 150, '2026-06-20 22:38:48'),
(6, 6, 150, '2026-06-20 22:49:18'),
(7, 8, 150, '2026-06-20 23:02:36'),
(8, 8, 245, '2026-06-20 23:03:32'),
(9, 8, 100, '2026-06-20 23:04:07'),
(10, 8, 50, '2026-06-20 23:04:13'),
(11, 8, 2345, '2026-06-24 01:57:36'),
(12, 8, 245, '2026-06-27 17:17:24'),
(13, 6, 25, '2026-06-27 21:33:30'),
(14, 6, 25, '2026-06-27 21:46:24'),
(15, 6, 26, '2026-06-27 21:46:33'),
(16, 6, 26, '2026-06-27 21:59:21'),
(17, 8, 25, '2026-06-27 22:00:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumo_gas`
--

CREATE TABLE `consumo_gas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `consumo` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `consumo_gas`
--

INSERT INTO `consumo_gas` (`id`, `usuario_id`, `consumo`, `fecha`) VALUES
(1, 6, 6789, '2026-06-17 03:17:56'),
(2, 8, 20, '2026-06-20 23:06:24'),
(3, 8, 10, '2026-06-20 23:06:30'),
(4, 8, 100, '2026-06-20 23:06:33'),
(5, 8, 245, '2026-06-27 17:17:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activa','archivada') DEFAULT 'activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `contenido`, `imagen`, `fecha`, `estado`) VALUES
(6, 'Causas Principales del cambio climatico', 'qqqqqqqqqqqqqqqq', '', '2026-06-23 03:26:05', 'archivada'),
(7, 'Consecuencias Globales y Locales', 'El cambio climático es la alteración global y prolongada de las temperaturas y patrones meteorológicos de la Tierra. Es impulsado principalmente por la actividad humana —como la quema de combustibles fósiles (carbón, petróleo y gas)—, lo cual incrementa los gases de efecto invernadero y retiene un exceso de calor en la atmósfera', '1782264312_cambio-climatico-riesgo-economia.webp', '2026-06-24 01:25:12', 'archivada'),
(9, 'Causas Principales del cambio climatico', 'yo', '', '2026-06-24 01:46:22', 'activa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reciclaje`
--

CREATE TABLE `reciclaje` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `material` varchar(100) DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `puntos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reciclaje`
--

INSERT INTO `reciclaje` (`id`, `usuario_id`, `material`, `cantidad`, `fecha`, `puntos`) VALUES
(1, 5, 'Papel', 10, '2026-06-14 03:56:14', 100),
(2, 5, 'Plástico', 12, '2026-06-14 03:56:20', 120),
(3, 8, 'Vidrio', 134, '2026-06-15 00:09:16', 1340),
(4, 8, 'Papel', 13, '2026-06-15 00:09:24', 130),
(5, 8, 'Metal', 245, '2026-06-15 00:09:33', 2450),
(6, 6, 'Plástico', 3, '2026-06-17 03:18:39', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendaciones`
--

CREATE TABLE `recomendaciones` (
  `id` int(11) NOT NULL,
  `tipo` enum('energia','agua','gas') DEFAULT NULL,
  `consumo_min` float DEFAULT NULL,
  `consumo_max` float DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `activa` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recomendaciones`
--

INSERT INTO `recomendaciones` (`id`, `tipo`, `consumo_min`, `consumo_max`, `titulo`, `descripcion`, `activa`) VALUES
(1, 'energia', 25, 49.98, 'Buen trabajo', 'Exelente trabajo sigue asi', 1),
(2, 'energia', 25, 49.98, 'Buen trabajo', 'Exelente trabajo sigue asi', 1);

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
  `foto` varchar(255) DEFAULT 'default.png',
  `telefono` varchar(20) DEFAULT NULL,
  `tipo_usuario` enum('personal','empresa') DEFAULT 'personal',
  `eco_puntos` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `rol`, `fecha_registro`, `foto`, `telefono`, `tipo_usuario`, `eco_puntos`) VALUES
(5, 'christian refugio', 'christiamtz@gmail.com', '$2y$10$HkvX2lo.u9RJndLMpqtTJuxEha3qxTq9A2k/y42NBd1F3rLysvsGy', 'usuario', '2026-06-10 01:28:52', '1781407200_6a2e1de0ab31b.jpg', '8123456276', 'personal', 220),
(6, 'Admin', 'admin@ecosmart.com', '$2y$10$cD8dWbGfXuqgThqqsOLc7.PKxBGFfA5BoTxsYlrF2K/ahfZz64MKK', 'admin', '2026-06-10 01:31:07', '1781055067_6a28be5b00974.jpeg', '3243543423', 'personal', 30),
(8, 'Hector del Toro', 'hector@gmail.com', '$2y$10$lnnElT3t/.XNa4wDcYy4I.mNUrTjDZOmeSwYP7u5SPhSXynZfHsjy', 'usuario', '2026-06-15 00:08:40', '1781482120_6a2f4288c932d.jpg', '2326778990', 'personal', 3920);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consumo_agua`
--
ALTER TABLE `consumo_agua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `consumo_energetico`
--
ALTER TABLE `consumo_energetico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `consumo_gas`
--
ALTER TABLE `consumo_gas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reciclaje`
--
ALTER TABLE `reciclaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `recomendaciones`
--
ALTER TABLE `recomendaciones`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `consumo_agua`
--
ALTER TABLE `consumo_agua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `consumo_energetico`
--
ALTER TABLE `consumo_energetico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `consumo_gas`
--
ALTER TABLE `consumo_gas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reciclaje`
--
ALTER TABLE `reciclaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `recomendaciones`
--
ALTER TABLE `recomendaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumo_agua`
--
ALTER TABLE `consumo_agua`
  ADD CONSTRAINT `consumo_agua_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `consumo_energetico`
--
ALTER TABLE `consumo_energetico`
  ADD CONSTRAINT `consumo_energetico_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `consumo_gas`
--
ALTER TABLE `consumo_gas`
  ADD CONSTRAINT `consumo_gas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `reciclaje`
--
ALTER TABLE `reciclaje`
  ADD CONSTRAINT `reciclaje_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
