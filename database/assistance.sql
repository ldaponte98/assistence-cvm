-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-02-2024 a las 00:21:08
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `assistance`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conection_group`
--

CREATE TABLE `conection_group` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `red` text COLLATE utf8_spanish_ci NOT NULL,
  `initial_age` int(11) NOT NULL,
  `final_age` int(11) NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conection_group_assistant`
--

CREATE TABLE `conection_group_assistant` (
  `id` int(11) NOT NULL,
  `conection_group_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conection_group_leaders`
--

CREATE TABLE `conection_group_leaders` (
  `id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `conection_group_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conection_group_segment_leaders`
--

CREATE TABLE `conection_group_segment_leaders` (
  `id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `conection_group_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `type` text COLLATE utf8_spanish_ci NOT NULL,
  `red` text COLLATE utf8_spanish_ci NOT NULL,
  `conection_group_id` int(11) DEFAULT NULL,
  `title` text COLLATE utf8_spanish_ci NOT NULL,
  `start` timestamp NOT NULL DEFAULT current_timestamp(),
  `end` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by_id` int(11) NOT NULL,
  `observations` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `managed` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_assistance`
--

CREATE TABLE `event_assistance` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `attended` int(11) NOT NULL DEFAULT 1,
  `isNew` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `message` text COLLATE utf8_spanish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_spanish_ci NOT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `path` text COLLATE utf8_spanish_ci NOT NULL,
  `icon` text COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `father_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `title`, `orden`, `path`, `icon`, `father_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Usuarios', 3, 'user/all', 'users', NULL, 1, '2024-01-19 22:43:18', '2024-01-19 22:43:18'),
(2, 'Base de datos', 1, 'people/all', 'database', NULL, 1, '2024-01-23 20:53:11', '2024-01-23 20:53:11'),
(3, 'Eventos', 1, 'event/all', 'calendar', NULL, 1, '2024-01-25 04:07:00', '2024-01-25 04:07:00'),
(4, 'Grupos de conexión', 2, 'conection-group/all', 'wifi', NULL, 1, '2024-01-26 16:26:24', '2024-01-26 16:26:24'),
(5, 'Inicio', 0, 'panel', 'home', NULL, 1, '2024-01-30 20:27:45', '2024-01-30 20:27:45'),
(6, 'Mi grupo de conexión', 1, 'conection-group/me-group', 'heart', NULL, 1, '2024-02-07 20:36:30', '2024-02-07 20:36:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_profile`
--

CREATE TABLE `menu_profile` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `menu_profile`
--

INSERT INTO `menu_profile` (`id`, `menu_id`, `profile_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-01-20 16:22:20', '2024-01-20 16:22:20'),
(2, 2, 1, 1, '2024-01-23 20:53:31', '2024-01-23 20:53:31'),
(3, 1, 2, 1, '2024-01-24 16:19:44', '2024-01-24 16:19:44'),
(4, 3, 1, 1, '2024-01-25 04:07:18', '2024-01-25 04:07:18'),
(5, 3, 2, 1, '2024-01-25 04:07:28', '2024-01-25 04:07:28'),
(6, 4, 1, 1, '2024-01-26 16:44:50', '2024-01-26 16:44:50'),
(7, 1, 5, 1, '2024-01-26 16:49:00', '2024-01-26 16:49:00'),
(8, 3, 5, 1, '2024-01-26 16:49:00', '2024-01-26 16:49:00'),
(9, 4, 5, 1, '2024-01-26 16:49:00', '2024-01-26 16:49:00'),
(10, 2, 5, 1, '2024-01-26 16:49:00', '2024-01-26 16:49:00'),
(11, 5, 4, 1, '2024-01-30 20:28:37', '2024-01-30 20:28:37'),
(12, 5, 5, 1, '2024-01-30 20:28:37', '2024-01-30 20:28:37'),
(13, 5, 3, 1, '2024-01-30 20:28:37', '2024-01-30 20:28:37'),
(14, 5, 2, 1, '2024-01-30 20:28:37', '2024-01-30 20:28:37'),
(15, 5, 1, 1, '2024-01-30 20:28:37', '2024-01-30 20:28:37'),
(16, 6, 3, 1, '2024-02-07 20:37:11', '2024-02-07 20:37:11'),
(17, 6, 2, 1, '2024-02-07 20:37:11', '2024-02-07 20:37:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `document` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `type` text COLLATE utf8_spanish_ci NOT NULL,
  `fullname` text COLLATE utf8_spanish_ci NOT NULL,
  `lastname` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `gender` text COLLATE utf8_spanish_ci NOT NULL,
  `phone` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `status` text COLLATE utf8_spanish_ci NOT NULL DEFAULT 'ACTIVO',
  `created_by_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`id`, `document`, `type`, `fullname`, `lastname`, `gender`, `phone`, `email`, `status`, `created_by_id`, `created_at`, `updated_at`) VALUES
(1, '1065843703', 'LEADER', 'SA', '', 'M', '3164689467', 'ldaponte98@gmail.com', 'ACTIVE', 1, '2024-01-20 15:46:52', '2024-01-24 21:05:15'),
(2, '1065826130', 'SEGMENT_LEADER', 'Angie Lorena', 'Perez Florian', 'F', '3015143005', 'angielperez@unicesar.edu.co', 'ACTIVE', 1, '2024-01-24 20:54:02', '2024-01-26 22:17:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrador', 1, '2024-01-19 22:40:49', '2024-01-19 22:40:49'),
(2, 'Lider de segmento', 1, '2024-01-20 15:43:17', '2024-01-20 15:43:17'),
(3, 'Lider', 1, '2024-01-20 15:43:17', '2024-01-20 15:43:17'),
(4, 'Asistente', 1, '2024-01-20 15:43:17', '2024-01-20 15:43:17'),
(5, 'Auditor de red', 1, '2024-01-26 16:46:15', '2024-01-26 16:46:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `code` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` text COLLATE utf8_spanish_ci NOT NULL,
  `father_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `profile_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  `red` text COLLATE utf8_spanish_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `profile_id`, `people_id`, `red`, `status`, `created_by_id`, `created_at`, `updated_at`) VALUES
(1, 'cvm', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, NULL, 1, 1, '2024-01-20 15:47:31', '2024-01-24 03:05:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conection_group`
--
ALTER TABLE `conection_group`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conection_group_assistant`
--
ALTER TABLE `conection_group_assistant`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conection_group_leaders`
--
ALTER TABLE `conection_group_leaders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `conection_group_segment_leaders`
--
ALTER TABLE `conection_group_segment_leaders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `event_assistance`
--
ALTER TABLE `event_assistance`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_profile`
--
ALTER TABLE `menu_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_profile_profile_fk` (`profile_id`),
  ADD KEY `menu_profile_menu_fk` (`menu_id`);

--
-- Indices de la tabla `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profile_fk` (`profile_id`),
  ADD KEY `user_people_fk` (`people_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conection_group`
--
ALTER TABLE `conection_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `conection_group_assistant`
--
ALTER TABLE `conection_group_assistant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `conection_group_leaders`
--
ALTER TABLE `conection_group_leaders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `conection_group_segment_leaders`
--
ALTER TABLE `conection_group_segment_leaders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `event_assistance`
--
ALTER TABLE `event_assistance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menu_profile`
--
ALTER TABLE `menu_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `menu_profile`
--
ALTER TABLE `menu_profile`
  ADD CONSTRAINT `menu_profile_menu_fk` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `menu_profile_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_people_fk` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `user_profile_fk` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
