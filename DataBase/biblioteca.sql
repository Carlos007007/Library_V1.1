-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-04-2018 a las 15:40:30
-- Versión del servidor: 10.1.24-MariaDB
-- Versión de PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `CodigoAdmin` varchar(70) NOT NULL,
  `Estado` varchar(30) NOT NULL,
  `Nombre` varchar(70) NOT NULL,
  `NombreUsuario` varchar(50) NOT NULL,
  `Clave` varchar(535) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`CodigoAdmin`, `Estado`, `Nombre`, `NombreUsuario`, `Clave`, `Email`) VALUES
('I777YA1N5802', 'Activo', 'Super Administrador', 'SuperAdministrador', 'YnRXSjhwRTNTRXJpV3k0MUtVSTloQT09', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `Codigo` varchar(100) NOT NULL,
  `CodigoUsuario` varchar(70) NOT NULL,
  `Tipo` varchar(30) NOT NULL,
  `Fecha` varchar(30) NOT NULL,
  `Entrada` varchar(30) NOT NULL,
  `Salida` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `CodigoCategoria` varchar(20) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `DUI` varchar(20) NOT NULL,
  `CodigoSeccion` varchar(70) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `NombreUsuario` varchar(50) NOT NULL,
  `Clave` varchar(535) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Telefono` int(20) NOT NULL,
  `Especialidad` varchar(40) NOT NULL,
  `Jornada` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encargado`
--

CREATE TABLE `encargado` (
  `DUI` varchar(20) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Telefono` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `NIE` varchar(20) NOT NULL,
  `DUI` varchar(20) NOT NULL,
  `CodigoSeccion` varchar(70) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `NombreUsuario` varchar(50) NOT NULL,
  `Clave` varchar(535) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Parentesco` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `institucion`
--

CREATE TABLE `institucion` (
  `CodigoInfraestructura` varchar(30) NOT NULL,
  `Nombre` varchar(70) NOT NULL,
  `NombreDirector` varchar(100) NOT NULL,
  `NombreBibliotecario` varchar(100) NOT NULL,
  `Distrito` varchar(30) NOT NULL,
  `Telefono` int(8) NOT NULL,
  `Year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `CodigoLibro` varchar(100) NOT NULL,
  `CodigoCorrelativo` varchar(20) NOT NULL,
  `CodigoCategoria` varchar(20) NOT NULL,
  `CodigoProveedor` varchar(70) NOT NULL,
  `CodigoInfraestructura` varchar(20) NOT NULL,
  `Autor` varchar(70) NOT NULL,
  `Pais` varchar(50) NOT NULL,
  `Year` varchar(7) NOT NULL,
  `Estimado` decimal(30,2) NOT NULL,
  `Titulo` varchar(77) NOT NULL,
  `Edicion` varchar(50) NOT NULL,
  `Ubicacion` varchar(50) NOT NULL,
  `Cargo` varchar(7) NOT NULL,
  `Editorial` varchar(70) NOT NULL,
  `Existencias` int(7) NOT NULL,
  `Prestado` int(20) NOT NULL,
  `Estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `DUI` varchar(20) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `NombreUsuario` varchar(50) NOT NULL,
  `Clave` varchar(535) NOT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Telefono` int(20) NOT NULL,
  `Cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `CodigoPrestamo` varchar(70) NOT NULL,
  `CodigoLibro` varchar(100) NOT NULL,
  `CorrelativoLibro` text NOT NULL,
  `CodigoAdmin` varchar(70) NOT NULL,
  `FechaSalida` varchar(30) NOT NULL,
  `FechaEntrega` varchar(30) NOT NULL,
  `Estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamodocente`
--

CREATE TABLE `prestamodocente` (
  `CodigoPrestamo` varchar(70) NOT NULL,
  `DUI` varchar(20) NOT NULL,
  `Cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamoestudiante`
--

CREATE TABLE `prestamoestudiante` (
  `CodigoPrestamo` varchar(70) NOT NULL,
  `NIE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamopersonal`
--

CREATE TABLE `prestamopersonal` (
  `CodigoPrestamo` varchar(70) NOT NULL,
  `DUI` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamovisitante`
--

CREATE TABLE `prestamovisitante` (
  `CodigoPrestamo` varchar(70) NOT NULL,
  `DUI` varchar(20) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Telefono` int(20) NOT NULL,
  `Institucion` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `CodigoProveedor` varchar(70) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Direccion` varchar(70) NOT NULL,
  `Telefono` int(15) NOT NULL,
  `ResponAtencion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `CodigoSeccion` varchar(70) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`CodigoAdmin`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`Codigo`),
  ADD KEY `PrimaryKey` (`CodigoUsuario`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`CodigoCategoria`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`DUI`),
  ADD KEY `CodigoSeccion` (`CodigoSeccion`);

--
-- Indices de la tabla `encargado`
--
ALTER TABLE `encargado`
  ADD PRIMARY KEY (`DUI`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`NIE`),
  ADD KEY `DUI` (`DUI`),
  ADD KEY `CodigoSeccion` (`CodigoSeccion`);

--
-- Indices de la tabla `institucion`
--
ALTER TABLE `institucion`
  ADD PRIMARY KEY (`CodigoInfraestructura`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`CodigoLibro`),
  ADD KEY `CodigoCategoria` (`CodigoCategoria`),
  ADD KEY `CodigoProveedor` (`CodigoProveedor`),
  ADD KEY `CodigoInfraestructura` (`CodigoInfraestructura`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`DUI`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`CodigoPrestamo`),
  ADD KEY `CodigoLibro` (`CodigoLibro`),
  ADD KEY `CodigoAdmin` (`CodigoAdmin`);

--
-- Indices de la tabla `prestamodocente`
--
ALTER TABLE `prestamodocente`
  ADD KEY `CodigoPrestamo` (`CodigoPrestamo`),
  ADD KEY `DUI` (`DUI`),
  ADD KEY `CodigoPrestamo_2` (`CodigoPrestamo`);

--
-- Indices de la tabla `prestamoestudiante`
--
ALTER TABLE `prestamoestudiante`
  ADD KEY `CodigoPrestamo` (`CodigoPrestamo`),
  ADD KEY `NIE` (`NIE`);

--
-- Indices de la tabla `prestamopersonal`
--
ALTER TABLE `prestamopersonal`
  ADD KEY `CodigoPrestamo` (`CodigoPrestamo`),
  ADD KEY `DUI` (`DUI`);

--
-- Indices de la tabla `prestamovisitante`
--
ALTER TABLE `prestamovisitante`
  ADD KEY `CodigoPrestamo` (`CodigoPrestamo`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`CodigoProveedor`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`CodigoSeccion`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`CodigoSeccion`) REFERENCES `seccion` (`CodigoSeccion`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`DUI`) REFERENCES `encargado` (`DUI`),
  ADD CONSTRAINT `estudiante_ibfk_2` FOREIGN KEY (`CodigoSeccion`) REFERENCES `seccion` (`CodigoSeccion`);

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_3` FOREIGN KEY (`CodigoCategoria`) REFERENCES `categoria` (`CodigoCategoria`),
  ADD CONSTRAINT `libro_ibfk_4` FOREIGN KEY (`CodigoProveedor`) REFERENCES `proveedor` (`CodigoProveedor`),
  ADD CONSTRAINT `libro_ibfk_5` FOREIGN KEY (`CodigoInfraestructura`) REFERENCES `institucion` (`CodigoInfraestructura`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_5` FOREIGN KEY (`CodigoLibro`) REFERENCES `libro` (`CodigoLibro`),
  ADD CONSTRAINT `prestamo_ibfk_6` FOREIGN KEY (`CodigoAdmin`) REFERENCES `administrador` (`CodigoAdmin`);

--
-- Filtros para la tabla `prestamodocente`
--
ALTER TABLE `prestamodocente`
  ADD CONSTRAINT `prestamodocente_ibfk_1` FOREIGN KEY (`CodigoPrestamo`) REFERENCES `prestamo` (`CodigoPrestamo`),
  ADD CONSTRAINT `prestamodocente_ibfk_2` FOREIGN KEY (`DUI`) REFERENCES `docente` (`DUI`);

--
-- Filtros para la tabla `prestamoestudiante`
--
ALTER TABLE `prestamoestudiante`
  ADD CONSTRAINT `prestamoestudiante_ibfk_1` FOREIGN KEY (`NIE`) REFERENCES `estudiante` (`NIE`),
  ADD CONSTRAINT `prestamoestudiante_ibfk_2` FOREIGN KEY (`CodigoPrestamo`) REFERENCES `prestamo` (`CodigoPrestamo`);

--
-- Filtros para la tabla `prestamopersonal`
--
ALTER TABLE `prestamopersonal`
  ADD CONSTRAINT `prestamopersonal_ibfk_1` FOREIGN KEY (`CodigoPrestamo`) REFERENCES `prestamo` (`CodigoPrestamo`),
  ADD CONSTRAINT `prestamopersonal_ibfk_2` FOREIGN KEY (`DUI`) REFERENCES `personal` (`DUI`);

--
-- Filtros para la tabla `prestamovisitante`
--
ALTER TABLE `prestamovisitante`
  ADD CONSTRAINT `prestamovisitante_ibfk_1` FOREIGN KEY (`CodigoPrestamo`) REFERENCES `prestamo` (`CodigoPrestamo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
