-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2019 a las 21:56:07
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
(3, 'Secretario delegado'),
(4, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secretariosdelegados`
--

CREATE TABLE `secretariosdelegados` (
  `Id_Secretario` int(11) NOT NULL,
  `Id_Votacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `secretariosdelegados`
--

INSERT INTO `secretariosdelegados` (`Id_Secretario`, `Id_Votacion`) VALUES
(4, 3),
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
(2, 2, 'a00000000', '$2y$12$sZ9YHmBqYETwRKfIKGSUT.4ti4rlapaM5uYNj2M.tn21KxSGlytLG'),
(3, 3, 'u12345678', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.'),
(5, 1, 'u55555555', '$2y$12$aecF4Ak8JHHsEWHHoVzs7.UQ/IXMpyekhuG8vXjJ61HXy5aJ84WV.');

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
(1, 2, 0),
(1, 5, 2),
(5, 3, 1),
(5, 1, 0);

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
(1, 'Primera Votacion', 'Esta es la primera votacion de mi sistema, y he sido modificada', '2019-11-10', '2019-11-16', 0),
(2, 'Otra Votacion modificada', 'Soy otra votacion', '2019-11-24', '2019-11-27', 0),
(3, 'otra jejejje ', 'fvfdbghggh', '2019-11-11', '2019-11-16', 0),
(4, 'ME HE MODIFICADO', 'fvfdbghggh', '2019-11-11', '2019-11-17', 0),
(5, 'no sé que hago con mi vida 2', 'Vota si este humilde señor deberia de comer macarrones o lentejas', '2019-11-11', '2019-11-13', 0),
(8, 'prueba45', 'fgfdg', '2019-11-26', '2019-11-30', 0),
(9, 'prueba50', 'gffdgsdfg', '2019-12-01', '2019-12-07', 1);

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
(0, 'Si'),
(1, 'No'),
(2, 'Blanco'),
(3, 'Abstencion');

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `votacion`
--
ALTER TABLE `votacion`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `voto`
--
ALTER TABLE `voto`
  MODIFY `Id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
