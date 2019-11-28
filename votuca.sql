-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-11-2019 a las 10:45:17
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `votuca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `censo`
--

CREATE TABLE `censo` (
  `Id_Usuario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `censo`
--

INSERT INTO `censo` (`Id_Usuario`, `Id_Votacion`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(8, 2),
(8, 3),
(8, 4),
(9, 2),
(9, 3),
(9, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficheros_censo`
--

CREATE TABLE `ficheros_censo` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ficheros_censo`
--

INSERT INTO `ficheros_censo` (`Id`, `Nombre`) VALUES
(1, 'censo1'),
(2, 'censo2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_electoral`
--

CREATE TABLE `mesa_electoral` (
  `Id_Usuario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesa_electoral`
--

INSERT INTO `mesa_electoral` (`Id_Usuario`, `Id_Votacion`) VALUES
(1, 1),
(1, 2),
(3, 1),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(6, 3),
(6, 4),
(8, 4),
(9, 2),
(9, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id` int(32) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id`, `Nombre`) VALUES
(4, 'Administrador'),
(1, 'Elector'),
(5, 'MiembroElectoral'),
(2, 'Secretario'),
(3, 'SecretarioDelegado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secretarios_delegados`
--

CREATE TABLE `secretarios_delegados` (
  `Id_Secretario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `secretarios_delegados`
--

INSERT INTO `secretarios_delegados` (`Id_Secretario`, `Id_Votacion`) VALUES
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(32) NOT NULL,
  `Id_Rol` int(32) NOT NULL,
  `NombreUsuario` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(256) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `Id_Rol`, `NombreUsuario`, `Password`) VALUES
(1, 1, 'u00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(2, 4, 'a00000000', '$2y$12$sZ9YHmBqYETwRKfIKGSUT.4ti4rlapaM5uYNj2M.tn21KxSGlytLG'),
(3, 3, 'u12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(4, 5, 'u11111111', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(5, 2, 's00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(6, 1, 'u12121212', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(7, 1, 'u13131313', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(8, 5, 'u14141414', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(9, 5, 'u15151515', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_votacion`
--

CREATE TABLE `usuario_votacion` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Votacion` int(32) NOT NULL,
  `Id_Voto` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_votacion`
--

INSERT INTO `usuario_votacion` (`Id_Usuario`, `Id_Votacion`, `Id_Voto`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(3, 1, 1),
(3, 2, 1),
(3, 3, 1),
(4, 1, 1),
(4, 2, 1),
(4, 3, 1),
(6, 1, 1),
(6, 2, 1),
(6, 3, 1),
(6, 4, 1),
(8, 2, 1),
(8, 3, 1),
(8, 4, 1),
(9, 2, 1),
(9, 3, 1),
(9, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion`
--

CREATE TABLE `votacion` (
  `Id` int(11) NOT NULL,
  `Titulo` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(1024) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFinal` datetime NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `esBorrador` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `votacion`
--

INSERT INTO `votacion` (`Id`, `Titulo`, `Descripcion`, `FechaInicio`, `FechaFinal`, `isDeleted`, `esBorrador`) VALUES
(1, 'Votacion 1', 'Descripción 1', '2019-11-27 09:40:00', '2019-11-29 09:00:00', 0, 0),
(2, 'Votacion 2', 'Descripción 2', '2019-12-01 09:00:00', '2019-12-04 09:00:00', 0, 0),
(3, 'Votación 3', 'Descripción 3', '2019-11-28 10:00:00', '2019-11-29 14:00:00', 0, 0),
(4, 'Votación 4', 'Descripción 4', '2019-12-03 09:00:00', '2019-12-05 09:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voto`
--

CREATE TABLE `voto` (
  `Id` int(32) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `voto`
--

INSERT INTO `voto` (`Id`, `Nombre`) VALUES
(1, 'No votado'),
(2, 'Sí'),
(3, 'No'),
(4, 'En blanco');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `censo`
--
ALTER TABLE `censo`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

--
-- Indices de la tabla `ficheros_censo`
--
ALTER TABLE `ficheros_censo`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `mesa_electoral`
--
ALTER TABLE `mesa_electoral`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `secretarios_delegados`
--
ALTER TABLE `secretarios_delegados`
  ADD PRIMARY KEY (`Id_Secretario`,`Id_Votacion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `NombreUsuario` (`NombreUsuario`),
  ADD KEY `Id_Rol` (`Id_Rol`);

--
-- Indices de la tabla `usuario_votacion`
--
ALTER TABLE `usuario_votacion`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`),
  ADD KEY `Id_Voto` (`Id_Voto`);

--
-- Indices de la tabla `votacion`
--
ALTER TABLE `votacion`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `voto`
--
ALTER TABLE `voto`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ficheros_censo`
--
ALTER TABLE `ficheros_censo`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `votacion`
--
ALTER TABLE `votacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `voto`
--
ALTER TABLE `voto`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `id_rol - con rol usario` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id`);

--
-- Filtros para la tabla `usuario_votacion`
--
ALTER TABLE `usuario_votacion`
  ADD CONSTRAINT `id voto con tabla voto id` FOREIGN KEY (`Id_Voto`) REFERENCES `voto` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
