-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2023 a las 07:22:27
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reservas-yate`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `perfil` text NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `perfil`, `nombre`, `usuario`, `password`, `estado`, `fecha`) VALUES
(1, 'Administrador', 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 1, '2023-05-05 07:06:27'),
(5, 'Empleado', 'Registrador', 'Registrador', '$2a$07$asxx54ahjppf45sd87a5aub7LdtrTXnn.ZQdALsthndsluPeTbv.a', 0, '2023-06-23 03:27:20'),
(10, 'Empleado', 'Franco', 'franco', '$2a$07$asxx54ahjppf45sd87a5auHC328efANf23/8RFe2mj0LEbEBfAlg6', 1, '2023-06-08 02:06:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `tipo` text NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `tipo`, `cantidad`, `fecha`) VALUES
(1, 'reservas', 0, '2020-08-23 01:49:14'),
(2, 'testimonios', 0, '2020-08-23 01:41:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `yate_id` int(11) NOT NULL,
  `administrador_id` int(11) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `pago_reserva` float DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `yate_id`, `administrador_id`, `fecha_reserva`, `fecha_inicio`, `fecha_salida`, `pago_reserva`, `nombre`, `correo`, `telefono`) VALUES
(114, 1, 1, '2023-05-21', '2023-05-23 02:00:00', '2023-05-23 05:00:00', 150, 'franco', 'franco@gmail.com', '981009096'),
(115, 4, 1, '2023-05-21', '2023-05-30 04:00:00', '2023-05-31 12:00:00', 2560, 'jose', 'jose@gmail.com', '981009696'),
(123, 5, 1, '2023-05-22', '2023-05-22 02:22:00', '2023-05-22 12:22:00', 450, 'perez', 'perez@gmail.com', '982008596'),
(126, 1, 10, '2023-06-07', '2023-06-07 13:00:00', '2023-06-07 16:00:00', 150, 'Diego', 'dmontalvan@gmail.com', '987009085'),
(127, 4, 1, '2023-06-19', '2023-06-20 15:00:00', '2023-06-20 19:30:00', 360, 'Franco', 'franco', '981009096'),
(128, 4, 1, '2023-06-22', '2023-06-23 12:00:00', '2023-06-23 18:30:00', 520, 'Yate Naranja wando', 'Renzo@gmail.com', '981009096'),
(129, 6, 1, '2023-06-22', '2023-06-23 12:30:00', '2023-06-23 20:00:00', 105, 'Definitivo', 'definitivo@gmail.com', '981009096'),
(130, 3, 1, '2023-06-23', '2023-06-25 12:00:00', '2023-06-25 15:30:00', 35, 'franco', 'Franco@gmail.com', '981009096');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `yates`
--

CREATE TABLE `yates` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `yates`
--

INSERT INTO `yates` (`id`, `nombre`, `capacidad`, `precio`, `descripcion`, `imagen`) VALUES
(1, 'Yate Azul', 10, 50, 'Yate diseno moderno y comodo', 'yate1.jpg'),
(2, 'Yate Dorado', 12, 20, 'Yate diseno moderno y comodo', 'yate2.jpg'),
(3, 'Yate Plateado', 8, 10, 'Yate diseno moderno y comodo', 'yate3.jpg'),
(4, 'Yate Rojo', 6, 80, 'Yate diseno moderno y comodo', 'yate4.jpg'),
(5, 'Yate Gris', 45, 45, 'Yate diseno moderno y comodo', 'yate5.jpg '),
(6, 'Yate Purpura', 47, 14, 'Yate diseno moderno y comodo', 'images.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_yate_id` (`yate_id`),
  ADD KEY `fk_administrador_id` (`administrador_id`);

--
-- Indices de la tabla `yates`
--
ALTER TABLE `yates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_administrador_id` FOREIGN KEY (`administrador_id`) REFERENCES `administradores` (`id`),
  ADD CONSTRAINT `fk_yate_id` FOREIGN KEY (`yate_id`) REFERENCES `yates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
