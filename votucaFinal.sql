-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-11-2019 a las 20:23:44
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
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(1, 2),
(2, 2),
(4, 2),
(1, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5),
(5, 5),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(1, 7),
(2, 7),
(3, 7),
(1, 8),
(2, 8),
(3, 8),
(4, 8),
(5, 8),
(1, 9),
(2, 9),
(3, 9),
(1, 10),
(2, 10),
(3, 10),
(10, 10),
(1, 11),
(2, 11),
(3, 11),
(4, 11),
(10, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `Id` int(11) NOT NULL,
  `Nombre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
(2, 1),
(4, 1),
(3, 1),
(4, 2),
(3, 2),
(1, 2),
(3, 4),
(4, 4),
(1, 4),
(3, 5),
(1, 5),
(5, 5),
(2, 6),
(1, 6),
(3, 6),
(1, 7),
(3, 7),
(2, 7),
(3, 8),
(1, 8),
(5, 8),
(3, 9),
(2, 9),
(1, 9),
(4, 10),
(7, 10),
(10, 10),
(7, 11),
(10, 11),
(9, 11);

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
(1, 'Elector'),
(2, 'Secretario'),
(3, 'SecretarioDelegado'),
(4, 'Administrador'),
(5, 'MiembroElectoral');

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
(3, 1),
(3, 5),
(3, 6),
(3, 8);

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
(6, 1, 'a00000000', '$2y$12$sZ9YHmBqYETwRKfIKGSUT.4ti4rlapaM5uYNj2M.tn21KxSGlytLG'),
(7, 1, 'u12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(8, 1, 'u11111111', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(9, 1, 's00000000', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.');

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
(1, 1, 0),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1),
(1, 2, 1),
(2, 2, 1),
(4, 2, 1),
(1, 3, 1),
(1, 4, 2),
(2, 4, 1),
(3, 4, 1),
(4, 4, 1),
(1, 5, 2),
(2, 5, 1),
(3, 5, 1),
(4, 5, 1),
(5, 5, 1),
(1, 6, 4),
(2, 6, 1),
(3, 6, 1),
(4, 6, 1),
(5, 6, 1),
(1, 7, 3),
(2, 7, 1),
(3, 7, 1),
(1, 8, 4),
(2, 8, 1),
(3, 8, 1),
(4, 8, 1),
(5, 8, 1),
(1, 9, 2),
(2, 9, 1),
(3, 9, 1),
(1, 10, 1),
(2, 10, 1),
(3, 10, 1),
(10, 10, 1),
(1, 11, 1),
(2, 11, 1),
(3, 11, 1),
(4, 11, 1),
(10, 11, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votacion`
--

CREATE TABLE `votacion` (
  `Id` int(11) NOT NULL,
  `Titulo` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `Descripcion` varchar(1024) COLLATE utf8_spanish_ci NOT NULL,
  `FechaInicio` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `isDelected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `votacion`
--

INSERT INTO `votacion` (`Id`, `Titulo`, `Descripcion`, `FechaInicio`, `FechaFinal`, `isDelected`) VALUES
(1, 'Primera', 'Descripcion 1', '2019-11-18', '2019-11-21', 0),
(2, 'Segunda', 'Descripcion 2', '2019-11-18', '2019-11-18', 0),
(3, 'Tercera terminada', 'Descripcion 3', '2019-11-11', '2019-11-16', 0),
(4, 'Cuarta', 'Descripcion 4', '2019-11-18', '2019-11-20', 0),
(5, 'Quinta', 'Descripcion 5', '2019-11-21', '2019-11-23', 0),
(6, 'Sexta', 'Descripcion 6', '2019-11-21', '2019-11-23', 0),
(7, 'Septima', 'Descripcion 7', '2019-11-24', '2019-11-30', 0),
(8, 'Octava', 'Descripcion 8', '2019-11-29', '2019-11-30', 1),
(9, 'Onceava ', 'dfhjkdsfhdkgdfsgg', '2019-11-21', '2019-11-23', 0),
(10, 'Votacion interesante', 'Esto es una votacion interesante', '2019-11-24', '2019-11-28', 0),
(11, 'Votacion interesante 2', 'Esto es una votacion interesante 2', '2019-11-28', '2019-12-03', 0);

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
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Id`);

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
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `voto`
--
ALTER TABLE `voto`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
