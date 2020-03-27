SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cerofila_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ausencias`
--

CREATE TABLE `ausencias` (
  `id_ausencia` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'tramitador',
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `motivo` text COLLATE utf8_spanish_ci,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` bigint(20) NOT NULL,
  `tramite_id` bigint(20) NOT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `fechahora` datetime NOT NULL,
  `nombre_ciudadano` text COLLATE utf8_spanish_ci NOT NULL,
  `appaterno_ciudadano` text COLLATE utf8_spanish_ci NOT NULL,
  `apmaterno_ciudadano` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci,
  `curp` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci,
  `folio` text COLLATE utf8_spanish_ci,
  `ip` text COLLATE utf8_spanish_ci,
  `statuscita` text COLLATE utf8_spanish_ci,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones`
--

CREATE TABLE `configuraciones` (
  `id_configuracion` bigint(20) NOT NULL,
  `service_name` text COLLATE utf8_unicode_ci NOT NULL,
  `service_key` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencias`
--

CREATE TABLE `dependencias` (
  `id_dependencia` bigint(20) NOT NULL,
  `nombre_dependencia` text COLLATE utf8_spanish_ci NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `holdingcitas`
--

CREATE TABLE `holdingcitas` (
  `id_holdingcita` bigint(20) NOT NULL,
  `tramite_id` bigint(20) DEFAULT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `fechahora` datetime NOT NULL,
  `folio` text COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla auxiliar para holdear citas/fechahora';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marquesinas`
--

CREATE TABLE `marquesinas` (
  `id_marquesina` bigint(20) NOT NULL,
  `textomarquesina` text NOT NULL,
  `oficina_id` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficinas`
--

CREATE TABLE `oficinas` (
  `id_oficina` bigint(20) NOT NULL,
  `nombre_oficina` text COLLATE utf8_spanish_ci NOT NULL,
  `slug` text COLLATE utf8_spanish_ci,
  `dependencia_id` bigint(20) NOT NULL,
  `coords` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish_ci,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramites`
--

CREATE TABLE `tramites` (
  `id_tramite` bigint(20) NOT NULL,
  `nombre_tramite` text COLLATE utf8_spanish_ci NOT NULL,
  `requisitos` text COLLATE utf8_spanish_ci,
  `tiempo_minutos` int(11) NOT NULL,
  `costo` text COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `dependencia_id` bigint(20) DEFAULT NULL,
  `warning_message` text COLLATE utf8_spanish_ci,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramitesxoficinas`
--

CREATE TABLE `tramitesxoficinas` (
  `id_tramitesxoficinas` bigint(20) NOT NULL,
  `tramite_id` bigint(20) NOT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `apply_date` datetime DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramitesxusers`
--

CREATE TABLE `tramitesxusers` (
  `id_tramitesxusers` bigint(20) NOT NULL,
  `tramite_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL COMMENT 'tramitador',
  `lunes_inicio` time DEFAULT NULL,
  `lunes_fin` time DEFAULT NULL,
  `martes_inicio` time DEFAULT NULL,
  `martes_fin` time DEFAULT NULL,
  `miercoles_inicio` time DEFAULT NULL,
  `miercoles_fin` time DEFAULT NULL,
  `jueves_inicio` time DEFAULT NULL,
  `jueves_fin` time DEFAULT NULL,
  `viernes_inicio` time DEFAULT NULL,
  `viernes_fin` time DEFAULT NULL,
  `sabado_inicio` time DEFAULT NULL,
  `sabado_fin` time DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tramites por usuarios tramitadores';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE `turnos` (
  `id_turno` bigint(20) NOT NULL,
  `cita_id` bigint(20) DEFAULT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL COMMENT 'tramitador',
  `tramite_id` bigint(20) NOT NULL,
  `fechahora_inicio` datetime DEFAULT NULL,
  `fechahora_fin` datetime DEFAULT NULL,
  `observaciones` longtext COLLATE utf8_spanish_ci,
  `nombre_ciudadano` text COLLATE utf8_spanish_ci,
  `curp` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci,
  `estatus` enum('creado','enproceso','finalizado','cancelado') COLLATE utf8_spanish_ci NOT NULL,
  `folio` text COLLATE utf8_spanish_ci NOT NULL,
  `tiempoaproxmin` bigint(20) NOT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) NOT NULL,
  `tipo_user` enum('superadmin','admin_oficina','kiosko','tramitador','turnera') COLLATE utf8_spanish_ci NOT NULL,
  `estatus` enum('activo','inactivo') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'activo',
  `email` text COLLATE utf8_spanish_ci,
  `password` text COLLATE utf8_spanish_ci,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `disponibleturno` enum('no','si') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'no',
  `ventanilla` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `REMEMBER_TOKEN` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id_valoracion` bigint(20) NOT NULL,
  `turno_id` bigint(20) NOT NULL,
  `folio` text COLLATE utf8_spanish_ci NOT NULL,
  `estrellas` int(11) DEFAULT NULL,
  `respuesta1` enum('si','no') COLLATE utf8_spanish_ci DEFAULT NULL,
  `respuesta2` enum('si','no') COLLATE utf8_spanish_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8_spanish_ci,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `id_video` bigint(20) NOT NULL,
  `urlvideo` text NOT NULL,
  `oficina_id` bigint(20) NOT NULL,
  `orden` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ausencias`
--
ALTER TABLE `ausencias`
  ADD PRIMARY KEY (`id_ausencia`),
  ADD KEY `tramitador_id` (`user_id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `oficina_id` (`oficina_id`),
  ADD KEY `tramite_id` (`tramite_id`);

--
-- Indices de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  ADD PRIMARY KEY (`id_configuracion`);

--
-- Indices de la tabla `dependencias`
--
ALTER TABLE `dependencias`
  ADD PRIMARY KEY (`id_dependencia`);

--
-- Indices de la tabla `holdingcitas`
--
ALTER TABLE `holdingcitas`
  ADD PRIMARY KEY (`id_holdingcita`),
  ADD KEY `oficina_id` (`oficina_id`);

--
-- Indices de la tabla `marquesinas`
--
ALTER TABLE `marquesinas`
  ADD PRIMARY KEY (`id_marquesina`);

--
-- Indices de la tabla `oficinas`
--
ALTER TABLE `oficinas`
  ADD PRIMARY KEY (`id_oficina`),
  ADD KEY `dependencia_id` (`dependencia_id`);

--
-- Indices de la tabla `tramites`
--
ALTER TABLE `tramites`
  ADD PRIMARY KEY (`id_tramite`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `tramitesxoficinas`
--
ALTER TABLE `tramitesxoficinas`
  ADD PRIMARY KEY (`id_tramitesxoficinas`),
  ADD KEY `oficina_id` (`oficina_id`),
  ADD KEY `tramite_id` (`tramite_id`);

--
-- Indices de la tabla `tramitesxusers`
--
ALTER TABLE `tramitesxusers`
  ADD PRIMARY KEY (`id_tramitesxusers`),
  ADD KEY `tramite_id` (`tramite_id`),
  ADD KEY `tramitador_id` (`user_id`);

--
-- Indices de la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD PRIMARY KEY (`id_turno`),
  ADD KEY `oficina_id` (`oficina_id`),
  ADD KEY `tramite_id` (`tramite_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `oficina_id` (`oficina_id`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id_valoracion`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id_video`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ausencias`
--
ALTER TABLE `ausencias`
  MODIFY `id_ausencia` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuraciones`
--
ALTER TABLE `configuraciones`
  MODIFY `id_configuracion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dependencias`
--
ALTER TABLE `dependencias`
  MODIFY `id_dependencia` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `holdingcitas`
--
ALTER TABLE `holdingcitas`
  MODIFY `id_holdingcita` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marquesinas`
--
ALTER TABLE `marquesinas`
  MODIFY `id_marquesina` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `oficinas`
--
ALTER TABLE `oficinas`
  MODIFY `id_oficina` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tramites`
--
ALTER TABLE `tramites`
  MODIFY `id_tramite` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tramitesxoficinas`
--
ALTER TABLE `tramitesxoficinas`
  MODIFY `id_tramitesxoficinas` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tramitesxusers`
--
ALTER TABLE `tramitesxusers`
  MODIFY `id_tramitesxusers` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `turnos`
--
ALTER TABLE `turnos`
  MODIFY `id_turno` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id_valoracion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `id_video` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
