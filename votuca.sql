-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-12-2019 a las 20:15:20
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.2.24

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `censo`
--

CREATE TABLE `censo` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Votacion` int(32) NOT NULL
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
  `Id_Usuario` int(32) NOT NULL,
  `Fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ficheros_censo`
--

CREATE TABLE `ficheros_censo` (
  `Id` int(32) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ficheros_censo`
--

INSERT INTO `ficheros_censo` (`Id`, `Nombre`) VALUES
(1, 'censo1'),
(2, 'censo2'),
(3, 'censoClientes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `Id` int(32) NOT NULL,
  `Nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`Id`, `Nombre`) VALUES
(1, 'PAS'),
(2, 'Alumnos'),
(3, 'Profesores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_electoral`
--

CREATE TABLE `mesa_electoral` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Votacion` int(32) NOT NULL,
  `seAbre` tinyint(1) NOT NULL,
  `seCierra` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ponderaciones`
--

CREATE TABLE `ponderaciones` (
  `Id_Votacion` int(32) NOT NULL,
  `Id_Grupo` int(32) NOT NULL,
  `Valor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recuento`
--

CREATE TABLE `recuento` (
  `Id_Votacion` int(32) NOT NULL,
  `Id_Grupo` int(32) NOT NULL,
  `Id_Voto` int(32) NOT NULL,
  `Num_Votos` int(64) NOT NULL
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
-- Estructura de tabla para la tabla `secretario_delegado`
--

CREATE TABLE `secretario_delegado` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Votacion` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_votacion`
--

CREATE TABLE `tipo_votacion` (
  `Id` int(32) NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_votacion`
--

INSERT INTO `tipo_votacion` (`Id`, `Nombre`) VALUES
(6, 'CargosUniponderados'),
(4, 'ConsultaCompleja'),
(3, 'ConsultaSimple'),
(5, 'EleccionRepresentantes'),
(2, 'VotacionCompleja'),
(1, 'VotacionSimple');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Id` int(32) NOT NULL,
  `Id_Rol` int(32) NOT NULL,
  `NombreUsuario` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Auth` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `IP` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Id`, `Id_Rol`, `NombreUsuario`, `Password`, `Email`, `Auth`, `IP`) VALUES
(1, 1, 'u00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(2, 4, 'a00000000', '$2y$12$sZ9YHmBqYETwRKfIKGSUT.4ti4rlapaM5uYNj2M.tn21KxSGlytLG', '', '', ''),
(3, 3, 's12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(5, 2, 's00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(6, 1, 'u12121212', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(7, 1, 'u13131313', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(8, 1, 'u12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(9, 1, 'u11111111', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(10, 1, 'u14141414', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(11, 1, 'u15151515', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(12, 5, 'm12121212', '$2y$10$ntRq/s8R03qUftM.nFKrkedVsfVx8eTmH7M.DkIB5WMb7LDJ3128e', '', '', ''),
(13, 5, 'm00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(14, 5, 'm11111111', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', ''),
(15, 5, 'm12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_censo`
--

CREATE TABLE `usuario_censo` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Fichero` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_grupo`
--

CREATE TABLE `usuario_grupo` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Grupo` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario_grupo`
--

INSERT INTO `usuario_grupo` (`Id_Usuario`, `Id_Grupo`) VALUES
(1, 2),
(1, 3),
(6, 2),
(7, 2),
(7, 3),
(8, 2),
(8, 3),
(9, 1),
(10, 1),
(10, 2),
(11, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_votacion`
--

CREATE TABLE `usuario_votacion` (
  `Id_Usuario` int(32) NOT NULL,
  `Id_Grupo` int(32) NOT NULL,
  `Id_Votacion` int(32) NOT NULL,
  `Id_Voto` varchar(1024) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion`
--

CREATE TABLE `votacion` (
  `Id` int(32) NOT NULL,
  `Id_TipoVotacion` int(32) NOT NULL,
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
  `Id_Votacion` int(32) NOT NULL,
  `Id_Fichero` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion_voto`
--

CREATE TABLE `votacion_voto` (
  `Id_Votacion` int(32) NOT NULL,
  `Id_Voto` int(32) NOT NULL
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
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`),
  ADD KEY `censo_ibfk_2` (`Id_Votacion`);

--
-- Indices de la tabla `censo_asistente`
--
ALTER TABLE `censo_asistente`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`),
  ADD KEY `censo_asistente_ibfk_2` (`Id_Votacion`);

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
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`),
  ADD KEY `mesa_electoral_ibfk_2` (`Id_Votacion`);

--
-- Indices de la tabla `ponderaciones`
--
ALTER TABLE `ponderaciones`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Grupo`),
  ADD KEY `ponderaciones_ibfk_1` (`Id_Grupo`);

--
-- Indices de la tabla `recuento`
--
ALTER TABLE `recuento`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Grupo`,`Id_Voto`),
  ADD KEY `recuento_ibfk_2` (`Id_Voto`),
  ADD KEY `Id_Grupo` (`Id_Grupo`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `secretario_delegado`
--
ALTER TABLE `secretario_delegado`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Votacion`);

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
  ADD KEY `id_rol - con rol usario` (`Id_Rol`);

--
-- Indices de la tabla `usuario_censo`
--
ALTER TABLE `usuario_censo`
  ADD PRIMARY KEY (`Id_Usuario`,`Id_Fichero`),
  ADD KEY `usuario_censo_ibfk_2` (`Id_Fichero`);

--
-- Indices de la tabla `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD KEY `Id_Usuario` (`Id_Usuario`,`Id_Grupo`),
  ADD KEY `id_grupo - con grupo` (`Id_Grupo`);

--
-- Indices de la tabla `votacion`
--
ALTER TABLE `votacion`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `id_tipo con tipo` (`Id_TipoVotacion`);

--
-- Indices de la tabla `votacion_censo`
--
ALTER TABLE `votacion_censo`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Fichero`),
  ADD KEY `votacion_censo_ibfk_1` (`Id_Fichero`);

--
-- Indices de la tabla `votacion_voto`
--
ALTER TABLE `votacion_voto`
  ADD PRIMARY KEY (`Id_Votacion`,`Id_Voto`),
  ADD KEY `votacion_voto_ibfk_2` (`Id_Voto`);

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
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_votacion`
--
ALTER TABLE `tipo_votacion`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `votacion`
--
ALTER TABLE `votacion`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `voto`
--
ALTER TABLE `voto`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `censo`
--
ALTER TABLE `censo`
  ADD CONSTRAINT `censo_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`),
  ADD CONSTRAINT `censo_ibfk_2` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`);

--
-- Filtros para la tabla `censo_asistente`
--
ALTER TABLE `censo_asistente`
  ADD CONSTRAINT `censo_asistente_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`),
  ADD CONSTRAINT `censo_asistente_ibfk_2` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`);

--
-- Filtros para la tabla `expiracion`
--
ALTER TABLE `expiracion`
  ADD CONSTRAINT `expiracion_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`);

--
-- Filtros para la tabla `mesa_electoral`
--
ALTER TABLE `mesa_electoral`
  ADD CONSTRAINT `mesa_electoral_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`),
  ADD CONSTRAINT `mesa_electoral_ibfk_2` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`);

--
-- Filtros para la tabla `ponderaciones`
--
ALTER TABLE `ponderaciones`
  ADD CONSTRAINT `ponderaciones_ibfk_1` FOREIGN KEY (`Id_Grupo`) REFERENCES `grupo` (`Id`),
  ADD CONSTRAINT `ponderaciones_ibfk_2` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`);

--
-- Filtros para la tabla `recuento`
--
ALTER TABLE `recuento`
  ADD CONSTRAINT `recuento_ibfk_1` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`),
  ADD CONSTRAINT `recuento_ibfk_2` FOREIGN KEY (`Id_Voto`) REFERENCES `voto` (`Id`),
  ADD CONSTRAINT `recuento_ibfk_3` FOREIGN KEY (`Id_Grupo`) REFERENCES `grupo` (`Id`);

--
-- Filtros para la tabla `secretario_delegado`
--
ALTER TABLE `secretario_delegado`
  ADD CONSTRAINT `secretario_delegado_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `id_rol - con rol usario` FOREIGN KEY (`Id_Rol`) REFERENCES `rol` (`Id`);

--
-- Filtros para la tabla `usuario_censo`
--
ALTER TABLE `usuario_censo`
  ADD CONSTRAINT `usuario_censo_ibfk_1` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`),
  ADD CONSTRAINT `usuario_censo_ibfk_2` FOREIGN KEY (`Id_Fichero`) REFERENCES `ficheros_censo` (`Id`);

--
-- Filtros para la tabla `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD CONSTRAINT `id_grupo - con grupo` FOREIGN KEY (`Id_Grupo`) REFERENCES `grupo` (`Id`),
  ADD CONSTRAINT `id_usuario - con usuario` FOREIGN KEY (`Id_Usuario`) REFERENCES `usuario` (`Id`);

--
-- Filtros para la tabla `votacion`
--
ALTER TABLE `votacion`
  ADD CONSTRAINT `id_tipo con tipo` FOREIGN KEY (`Id_TipoVotacion`) REFERENCES `tipo_votacion` (`Id`);

--
-- Filtros para la tabla `votacion_censo`
--
ALTER TABLE `votacion_censo`
  ADD CONSTRAINT `votacion_censo_ibfk_1` FOREIGN KEY (`Id_Fichero`) REFERENCES `ficheros_censo` (`Id`),
  ADD CONSTRAINT `votacion_censo_ibfk_2` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`);

--
-- Filtros para la tabla `votacion_voto`
--
ALTER TABLE `votacion_voto`
  ADD CONSTRAINT `votacion_voto_ibfk_1` FOREIGN KEY (`Id_Votacion`) REFERENCES `votacion` (`Id`),
  ADD CONSTRAINT `votacion_voto_ibfk_2` FOREIGN KEY (`Id_Voto`) REFERENCES `voto` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;