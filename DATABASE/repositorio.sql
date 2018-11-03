-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-11-2018 a las 01:20:36
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repositorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `IDAREA` int(11) NOT NULL,
  `NOMBRE` varchar(255) NOT NULL,
  `FKAREA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`IDAREA`, `NOMBRE`, `FKAREA`) VALUES
(10, 'AREA_10', 20),
(20, 'AREA_20', NULL),
(30, 'AREA_3', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `IDAUTOR` int(11) NOT NULL,
  `NOMBRE` varchar(255) NOT NULL,
  `NACIONALIDAD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`IDAUTOR`, `NOMBRE`, `NACIONALIDAD`) VALUES
(16108017, 'JUANCHILAS', 'VENEZOLANA'),
(1036685232, 'JUAN DAVID AGUIRRE CORDOBA', 'COLOMBIANA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

CREATE TABLE `material` (
  `IDMATERIAL` int(11) NOT NULL,
  `TITULO` varchar(255) NOT NULL,
  `DESCRIPCION` varchar(255) NOT NULL,
  `IMAGEN` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `material`
--

INSERT INTO `material` (`IDMATERIAL`, `TITULO`, `DESCRIPCION`, `IMAGEN`) VALUES
(12, 'Repositorio', 'Repositorio de datos', 'dream.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metadata`
--

CREATE TABLE `metadata` (
  `IDMETADATA` int(11) NOT NULL,
  `TIPO` varchar(255) NOT NULL,
  `METADATA` varchar(255) NOT NULL,
  `FECHAINGRESO` date NOT NULL,
  `FECHAMODIFICACION` date NOT NULL,
  `USUARIOINGRESO` varchar(255) NOT NULL,
  `AUDIENCIA` varchar(255) NOT NULL,
  `COMPATIBILIDAD` bit(1) NOT NULL,
  `IDIOMA` varchar(255) NOT NULL,
  `COSTO` decimal(10,0) NOT NULL,
  `IDMATERIAL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `metadata`
--

INSERT INTO `metadata` (`IDMETADATA`, `TIPO`, `METADATA`, `FECHAINGRESO`, `FECHAMODIFICACION`, `USUARIOINGRESO`, `AUDIENCIA`, `COMPATIBILIDAD`, `IDIOMA`, `COSTO`, `IDMATERIAL`) VALUES
(1, 'TIPOS', 'Repositorio.zip', '2018-11-03', '2018-11-03', 'JD1917', 'ESTUDIANTES', b'0', 'Espa?ol', '2000', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `IDPERMISO` int(11) NOT NULL,
  `NOMBRE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacionareamaterial`
--

CREATE TABLE `relacionareamaterial` (
  `IDMATERIAL` int(11) NOT NULL,
  `IDAREA` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relacionareamaterial`
--

INSERT INTO `relacionareamaterial` (`IDMATERIAL`, `IDAREA`) VALUES
(12, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacionmaterialautor`
--

CREATE TABLE `relacionmaterialautor` (
  `IDMATERIAL` int(11) NOT NULL,
  `IDAUTOR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `relacionmaterialautor`
--

INSERT INTO `relacionmaterialautor` (`IDMATERIAL`, `IDAUTOR`) VALUES
(12, 1036685232);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relacionrolpermiso`
--

CREATE TABLE `relacionrolpermiso` (
  `IDROL` int(11) NOT NULL,
  `IDPERMISO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `IDROL` int(11) NOT NULL,
  `NOMBRE` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`IDROL`, `NOMBRE`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'ESTUDIANTE'),
(3, 'PROFESOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IDUSUARIO` int(11) NOT NULL,
  `NOMBRE` varchar(255) NOT NULL,
  `IDROL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IDUSUARIO`, `NOMBRE`, `IDROL`) VALUES
(16108017, 'JD1917', 1),
(1036685232, 'JUAN', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`IDAREA`),
  ADD KEY `FKAREA` (`FKAREA`);

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`IDAUTOR`);

--
-- Indices de la tabla `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`IDMATERIAL`);

--
-- Indices de la tabla `metadata`
--
ALTER TABLE `metadata`
  ADD PRIMARY KEY (`IDMETADATA`),
  ADD KEY `IDMATERIAL` (`IDMATERIAL`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`IDPERMISO`);

--
-- Indices de la tabla `relacionareamaterial`
--
ALTER TABLE `relacionareamaterial`
  ADD PRIMARY KEY (`IDMATERIAL`,`IDAREA`),
  ADD KEY `IDAREA` (`IDAREA`);

--
-- Indices de la tabla `relacionmaterialautor`
--
ALTER TABLE `relacionmaterialautor`
  ADD PRIMARY KEY (`IDMATERIAL`,`IDAUTOR`),
  ADD KEY `IDAUTOR` (`IDAUTOR`);

--
-- Indices de la tabla `relacionrolpermiso`
--
ALTER TABLE `relacionrolpermiso`
  ADD PRIMARY KEY (`IDROL`,`IDPERMISO`),
  ADD KEY `IDPERMISO` (`IDPERMISO`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`IDROL`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IDUSUARIO`),
  ADD KEY `IDROL` (`IDROL`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `material`
--
ALTER TABLE `material`
  MODIFY `IDMATERIAL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `metadata`
--
ALTER TABLE `metadata`
  MODIFY `IDMETADATA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`FKAREA`) REFERENCES `area` (`IDAREA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `metadata`
--
ALTER TABLE `metadata`
  ADD CONSTRAINT `metadata_ibfk_1` FOREIGN KEY (`IDMATERIAL`) REFERENCES `material` (`IDMATERIAL`);

--
-- Filtros para la tabla `relacionareamaterial`
--
ALTER TABLE `relacionareamaterial`
  ADD CONSTRAINT `relacionareamaterial_ibfk_1` FOREIGN KEY (`IDAREA`) REFERENCES `area` (`IDAREA`),
  ADD CONSTRAINT `relacionareamaterial_ibfk_2` FOREIGN KEY (`IDMATERIAL`) REFERENCES `material` (`IDMATERIAL`);

--
-- Filtros para la tabla `relacionmaterialautor`
--
ALTER TABLE `relacionmaterialautor`
  ADD CONSTRAINT `relacionmaterialautor_ibfk_1` FOREIGN KEY (`IDMATERIAL`) REFERENCES `material` (`IDMATERIAL`),
  ADD CONSTRAINT `relacionmaterialautor_ibfk_2` FOREIGN KEY (`IDAUTOR`) REFERENCES `autor` (`IDAUTOR`);

--
-- Filtros para la tabla `relacionrolpermiso`
--
ALTER TABLE `relacionrolpermiso`
  ADD CONSTRAINT `relacionrolpermiso_ibfk_1` FOREIGN KEY (`IDROL`) REFERENCES `rol` (`IDROL`),
  ADD CONSTRAINT `relacionrolpermiso_ibfk_2` FOREIGN KEY (`IDPERMISO`) REFERENCES `permiso` (`IDPERMISO`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`IDROL`) REFERENCES `rol` (`IDROL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
