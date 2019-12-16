-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-12-2019 a las 17:21:11
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

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
-- Estructura de tabla para la tabla `autorizacion`
--

CREATE TABLE `autorizacion` (
  `auth_key` varchar(128) NOT NULL,
  `first_time` tinyint(1) NOT NULL,
  `attemps` int(11) NOT NULL,
  `blocked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `autorizacion`
--

INSERT INTO `autorizacion` (`auth_key`, `first_time`, `attemps`, `blocked`) VALUES
('I46J5QWAX4PCKL7I', 0, 0, 0),
('IXP5FNAVQVUIPQCP', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `censo`
--

CREATE TABLE `censo` (
  `Id_Usuario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `censo_asistente`
--

CREATE TABLE `censo_asistente` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Votacion` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expiracion`
--

CREATE TABLE `expiracion` (
  `Id_Usuario` int(11) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`Id`, `Nombre`) VALUES
(1, 'pinf5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_electoral`
--

CREATE TABLE `mesa_electoral` (
  `Id_Usuario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL,
  `seAbre` tinyint(1) NOT NULL,
  `seCierra` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ponderaciones`
--

CREATE TABLE `ponderaciones` (
  `Id_Votacion` int(11) NOT NULL,
  `Valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuento`
--

CREATE TABLE `recuento` (
  `Id_Votacion` int(11) NOT NULL,
  `Id_Voto` int(11) NOT NULL,
  `Num_Votos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Estructura de tabla para la tabla `tipo_votacion`
--

CREATE TABLE `tipo_votacion` (
  `Id` int(11) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_votacion`
--

INSERT INTO `tipo_votacion` (`Id`, `Nombre`) VALUES
(2, 'VotacionCompleja'),
(1, 'VotacionSimple');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(32) NOT NULL,
  `Id_Rol` int(32) NOT NULL,
  `Id_Grupo` int(32) NOT NULL,
  `NombreUsuario` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Auth` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `IP` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `Id_Rol`, `Id_Grupo`, `NombreUsuario`, `Password`, `Email`, `Auth`, `IP`) VALUES
(1, 1, 1, 'u00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', 'I46J5QWAX4PCKL7I', '::1'),
(2, 4, 1, 'a00000000', '$2y$12$sZ9YHmBqYETwRKfIKGSUT.4ti4rlapaM5uYNj2M.tn21KxSGlytLG', '', 'IXP5FNAVQVUIPQCP', '192.168.0.1'),
(3, 3, 1, 's12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(5, 2, 1, 's00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(6, 1, 1, 'u12121212', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(7, 1, 1, 'u13131313', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(8, 1, 1, 'u12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(9, 1, 1, 'u11111111', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(10, 1, 1, 'u14141414', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(11, 1, 1, 'u15151515', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(12, 5, 1, 'm12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(13, 5, 1, 'm11111111', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(14, 5, 1, 'm12121212', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(15, 5, 1, 'm14141414', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(16, 5, 1, 'm15151515', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1'),
(17, 5, 1, 'm00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_censo`
--

CREATE TABLE `usuario_censo` (
  `Id_Usuario` int(11) NOT NULL,
  `Id_Fichero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_votacion`
--

CREATE TABLE `usuario_votacion` (
  `Id_Usuario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL,
  `Id_Voto` varchar(1024) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion`
--

CREATE TABLE `votacion` (
  `Id` int(11) NOT NULL,
  `Id_TipoVotacion` int(11) NOT NULL,
  `Titulo` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(1024) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` datetime NOT NULL,
  `FechaFinal` datetime NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `esBorrador` tinyint(1) NOT NULL,
  `Finalizada` tinyint(1) NOT NULL,
  `Quorum` float NOT NULL,
  `Invalida` tinyint(1) NOT NULL,
  `VotoModificable` tinyint(1) NOT NULL,
  `SoloAsistentes` tinyint(1) NOT NULL,
  `RecuentoParalelo` tinyint(1) NOT NULL,
  `NumOpciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion_censo`
--

CREATE TABLE `votacion_censo` (
  `Id_Votacion` int(11) NOT NULL,
  `Id_Fichero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion_voto`
--

CREATE TABLE `votacion_voto` (
  `Id_Votacion` int(11) NOT NULL,
  `Id_Voto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Indices de la tabla `autorizacion`
--
ALTER TABLE `autorizacion`
  ADD PRIMARY KEY (`auth_key`),
  ADD UNIQUE KEY `auth_key` (`auth_key`);

--
-- Indices de la tabla `censo`
--
ALTER TABLE `censo`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

--
-- Indices de la tabla `censo_asistente`
--
ALTER TABLE `censo_asistente`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

--
-- Indices de la tabla `expiracion`
--
ALTER TABLE `expiracion`
  ADD PRIMARY KEY (`Id_Usuario`);

--
-- Indices de la tabla `ficheros_censo`
--
ALTER TABLE `ficheros_censo`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `mesa_electoral`
--
ALTER TABLE `mesa_electoral`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

--
-- Indices de la tabla `ponderaciones`
--
ALTER TABLE `ponderaciones`
  ADD KEY `Id_Votacion` (`Id_Votacion`);

--
-- Indices de la tabla `recuento`
--
ALTER TABLE `recuento`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Voto`);

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
-- Indices de la tabla `tipo_votacion`
--
ALTER TABLE `tipo_votacion`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `NombreUsuario` (`NombreUsuario`),
  ADD KEY `Id_Rol` (`Id_Rol`),
  ADD KEY `NombreUsuario_2` (`NombreUsuario`),
  ADD KEY `Id_Grupo` (`Id_Grupo`),
  ADD KEY `Id_Grupo_2` (`Id_Grupo`);

--
-- Indices de la tabla `usuario_censo`
--
ALTER TABLE `usuario_censo`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Fichero`);

--
-- Indices de la tabla `usuario_votacion`
--
ALTER TABLE `usuario_votacion`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

--
-- Indices de la tabla `votacion`
--
ALTER TABLE `votacion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_TipoVotacion` (`Id_TipoVotacion`),
  ADD KEY `Id_TipoVotacion_2` (`Id_TipoVotacion`);

--
-- Indices de la tabla `votacion_censo`
--
ALTER TABLE `votacion_censo`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Fichero`);

--
-- Indices de la tabla `votacion_voto`
--
ALTER TABLE `votacion_voto`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Voto`);

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
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_votacion`
--
ALTER TABLE `tipo_votacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `votacion`
--
ALTER TABLE `votacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `voto`
--
ALTER TABLE `voto`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ponderaciones`
--
ALTER TABLE `ponderaciones`
  ADD CONSTRAINT `Id_Votacion con su id` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `id_grupo - con grupo` FOREIGN KEY (`Id_Grupo`) REFERENCES `grupo` (`Id`),
  ADD CONSTRAINT `id_rol - con rol usario` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id`);

--
-- Filtros para la tabla `votacion`
--
ALTER TABLE `votacion`
  ADD CONSTRAINT `id_tipo con tipo` FOREIGN KEY (`Id_TipoVotacion`) REFERENCES `tipo_votacion` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
