-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2025 a las 09:39:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `examen1eval`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `imagen_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre`, `imagen_path`) VALUES
(2, 'Sofa', 'https://th.bing.com/th/id/OIP.rRhog0oVzP93Eq2_BwEE5wHaGa?rs=1&pid=ImgDetMain'),
(3, 'PC Gamer', 'https://th.bing.com/th/id/OIP.boyq38GO9i9aQQt-oWZZ2QHaEN?w=303&h=180&c=7&r=0&o=5&pid=1.7'),
(4, 'Lámpara', 'https://ovacen.com/wp-content/uploads/2015/04/luz-led-y-arquitectura.jpg'),
(8, 'Moto', 'https://i.pinimg.com/originals/a3/2c/8c/a32c8cab7d87a8dbc8270c0f12f912f7.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productosprueba`
--

CREATE TABLE `productosprueba` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productosprueba`
--

INSERT INTO `productosprueba` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `categoria`, `stock`, `fecha_creacion`) VALUES
(1, 'Camiseta Blanca', 'Camiseta de algodón 100% para uso diario.', 14.99, 'img/camiseta_blanca.jpg', 'Ropa', 50, '2025-05-08 07:23:02'),
(2, 'Zapatillas Running', 'Zapatillas ligeras y cómodas para correr.', 59.99, 'img/zapatillas_running.jpg', 'Calzado', 30, '2025-05-08 07:23:02'),
(3, 'Mochila Escolar', 'Mochila resistente con múltiples compartimentos.', 24.95, 'img/mochila_escolar.jpg', 'Accesorios', 20, '2025-05-08 07:23:02'),
(4, 'Auriculares Bluetooth', 'Auriculares inalámbricos con cancelación de ruido.', 39.90, 'img/auriculares_bt.jpg', 'Electrónica', 15, '2025-05-08 07:23:02'),
(5, 'Pantalón Jeans', 'Jeans de corte recto con ajuste moderno.', 29.95, 'img/jeans.jpg', 'Ropa', 40, '2025-05-08 07:23:02'),
(6, 'Reloj Digital', 'Reloj resistente al agua con cronómetro.', 19.95, 'img/reloj_digital.jpg', 'Accesorios', 25, '2025-05-08 07:23:02'),
(7, 'Sudadera Negra', 'Sudadera con capucha ideal para el invierno.', 34.99, 'img/sudadera_negra.jpg', 'Ropa', 35, '2025-05-08 07:23:02'),
(8, 'Smartphone X100', 'Teléfono inteligente con pantalla HD y gran batería.', 199.00, 'img/smartphone_x100.jpg', 'Electrónica', 10, '2025-05-08 07:23:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `nombre`, `contrasena`) VALUES
(12, 'eduard.f.soare@gmail.com', 'Edu', '$2y$10$IFHxwnUUc4UcwgEOJ5CFAOHv19jZ897Te.qQMfYHt4atUbsCjTMly'),
(13, 'prueba@gmail.com', 'Prueba', '$2y$10$qMoGRa0arK/9s/zOJL2Fle3hFz4jnYXiykyDYRCHKw6z6nSQiQloe');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `productosprueba`
--
ALTER TABLE `productosprueba`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productosprueba`
--
ALTER TABLE `productosprueba`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
