-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/09/2025 às 02:02
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `trinity_repair_test`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias_ticket`
--

CREATE TABLE `categorias_ticket` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias_ticket`
--

INSERT INTO `categorias_ticket` (`id`, `nombre`, `descripcion`, `activo`) VALUES
(1, 'Soporte Técnico', 'Problemas técnicos y errores del sistema', 1),
(2, 'Consulta General', 'Preguntas generales sobre el servicio', 1),
(3, 'Solicitud de Función', 'Peticiones de nuevas características', 1),
(4, 'Reporte de Bug', 'Reportes de errores en el sistema', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `asunto` varchar(150) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `respuesta` text DEFAULT NULL,
  `fecha_respuesta` timestamp NULL DEFAULT NULL,
  `visible_admin` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `consultas`
--

INSERT INTO `consultas` (`id`, `nombre`, `email`, `modelo`, `asunto`, `mensaje`, `fecha`, `respuesta`, `fecha_respuesta`, `visible_admin`) VALUES
(1, 'MANX', 'nahuel@gmail.com', 'iphone', '21', 'd', '2025-09-04 23:35:17', 'que paso', '2025-09-04 23:35:30', 1),
(2, 'MANX', 'nahuel@gmail.com', 'iphone', '21', 'd', '2025-09-04 23:35:39', NULL, NULL, 1),
(3, 'MANX', 'nahuel@gmail.com', '', '', 'd', '2025-09-04 23:37:26', NULL, NULL, 1),
(4, 'rulo', 'nahuel@gmail.com', '', '', 'mdm', '2025-09-04 23:37:38', NULL, NULL, 1),
(5, 'Agustin', 'nahuelsoytecnico@gmail.com', '', '', 'x', '2025-09-04 23:38:22', NULL, NULL, 1),
(6, 'w', 'nahuel@gmail.com', 'd', 'dedededede', 'sd', '2025-09-04 23:38:43', NULL, NULL, 1),
(7, 'rulo', 'Agustin31@gmail.com', '', '', 'd', '2025-09-04 23:40:13', NULL, NULL, 1),
(8, 'rulo', 'kaka@gmail.com', 'honor', 'preosupuesto', 'wd', '2025-09-04 23:44:37', 'si', '2025-09-04 23:44:51', 1),
(9, 'rulo', 'kaka@gmail.com', 'honor', 'preosupuesto', 'wd', '2025-09-04 23:44:58', NULL, NULL, 1),
(10, 'rulo', 'kaka@gmail.com', 'honor', 'preosupuesto', 'wd', '2025-09-04 23:46:19', NULL, NULL, 1),
(11, 'rulo', 'kaka@gmail.com', 'honor', 'preosupuesto', 'wd', '2025-09-04 23:47:13', NULL, NULL, 1),
(12, 'rulo', 'kaka@gmail.com', 'honor', 'preosupuesto', 'wd', '2025-09-04 23:47:21', NULL, NULL, 1),
(13, 'nahuel', 'kaka@gmail.com', 'iphone', '1', 'q', '2025-09-04 23:52:58', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tecnico` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `enviado_por` enum('cliente','tecnico') NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(3, 'cliente'),
(4, 'supervisor'),
(2, 'tecnico');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `tecnico_id` int(11) DEFAULT NULL,
  `estado` enum('Pendiente','Diagnóstico','Presupuesto','En Reparación','Finalizado','Cancelado') DEFAULT 'Pendiente',
  `presupuesto` decimal(10,2) DEFAULT NULL,
  `aprobado_cliente` tinyint(1) DEFAULT 0,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL,
  `prioridad` enum('baja','media','alta','urgente') DEFAULT 'media',
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tickets`
--

INSERT INTO `tickets` (`id`, `titulo`, `descripcion`, `cliente_id`, `tecnico_id`, `estado`, `presupuesto`, `aprobado_cliente`, `fecha_creacion`, `fecha_actualizacion`, `categoria_id`, `prioridad`, `admin_id`) VALUES
(20, 'honor', 'se rompio la pantalla', 136, 135, 'Finalizado', 1000.00, 1, '2025-09-01 18:30:27', '2025-09-01 18:33:13', 1, 'alta', 100),
(21, 'iphone 12', 'se rompio la pantalla', 14, 135, 'Finalizado', 1000.00, 1, '2025-09-01 18:34:22', '2025-09-01 18:36:39', 1, 'urgente', 100),
(23, 'motorola', 'roto', 138, 137, 'Finalizado', 100.00, 1, '2025-09-04 16:09:56', '2025-09-04 16:13:36', 1, 'urgente', 100);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `estado`, `rol_id`) VALUES
(14, 'kaka', 'kaka@gmail.com', '1234', 'activo', 3),
(100, 'nahuel', 'nahuel@gmail.com', '1234', 'activo', 1),
(134, 'nahuel', 'Agustin31@gmail.com', '1234', 'activo', 3),
(135, 'nahuel', 'tecnico1@gmail.com', '1234', 'activo', 2),
(136, 'rulo', 'rulo@gmail.com', '1234', 'activo', 3),
(137, 'lauchi', 'lauchi@gmail.com', '1234', 'activo', 2),
(138, 'michael', 'michael@gmail.com', '1234', 'activo', 3),
(139, 'yo', 'yo@gmail.com', '1234', 'activo', 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_mensaje` (`email`,`mensaje`,`fecha`) USING HASH;

--
-- Índices de tabela `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tecnico` (`id_tecnico`);

--
-- Índices de tabela `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Índices de tabela `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `tecnico_id` (`tecnico_id`),
  ADD KEY `fk_admin_ticket` (`admin_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuarios_roles` (`rol_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_tecnico`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_admin_ticket` FOREIGN KEY (`admin_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`tecnico_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
