-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2021 a las 13:45:39
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hibentus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comentario` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `comentario`, `imagen`) VALUES
(1, 'Deportes', 'Eventos relacionados con los deportes: fútbol, atletismo, baloncesto, ...', 'imgs/imgCat/cat-614474c371a2a.jpg'),
(2, 'Cultura', 'Eventos relacionados con la cultura: teatro, fiestas patronales, exposiciones, ...', 'imgs/imgCat/cat-614474e18462e.jpg'),
(3, 'Música', 'Eventos relacionados con la música: conciertos, recitales, festivales, ...', 'imgs/imgCat/cat-6144750315d6a.jpg'),
(4, 'Infantil', 'Eventos para los más pequeños: lecturas de libros, parques, espectáculos, ...', 'imgs/imgCat/cat-6144751a97092.jpg'),
(5, 'Naturaleza', 'Eventos en la naturaleza: rutas en bici, senderismo, escalada, ...', 'imgs/imgCat/cat-61447530e53fd.jpg'),
(6, 'Gastronomía', 'Eventos relacionados con la gastronomía: ferias, concursos, comidas populares, ...', 'imgs/imgCat/cat-61447547254d2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `comentario` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user_id` int(11) NOT NULL,
  `id_evento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `comentario`, `id_user_id`, `id_evento_id`) VALUES
(1, 'Comentario 1: ajdbskbjdkbjskdjnsknjcnkjsknjcsknjcnkjsknjcknjscknjs', 1, 1),
(2, 'Comentario 2: ahvdhjadbakdbjkbkjadbksc kjscbdc jkdc jdc  dkjcj dc jjdcnndcnjdcnkjdc', 1, 1),
(3, 'Comentario de prueba', 1, 6),
(4, 'segundo comentario', 1, 6),
(5, 'segundo comentario', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210913101214', '2021-09-13 12:12:31', 97),
('DoctrineMigrations\\Version20210913101850', '2021-09-13 12:18:55', 118),
('DoctrineMigrations\\Version20210913102836', '2021-09-13 12:28:41', 342),
('DoctrineMigrations\\Version20210913104907', '2021-09-13 12:49:25', 56),
('DoctrineMigrations\\Version20210913113249', '2021-09-13 13:32:54', 34),
('DoctrineMigrations\\Version20210914102157', '2021-09-14 12:22:15', 334),
('DoctrineMigrations\\Version20210916084218', '2021-09-16 10:42:33', 257),
('DoctrineMigrations\\Version20210916110051', '2021-09-16 13:01:07', 43);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `id_user_id` int(11) NOT NULL,
  `id_categoria_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `descripcion` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`, `id_user_id`, `id_categoria_id`, `fecha_creacion`, `descripcion`, `imagen`) VALUES
(1, 'Concierto FOO FIGHTERS', '2022-06-20 21:30:00', '2022-06-20 23:30:00', 1, 3, '2021-09-14 11:33:24', 'Con 10 álbumes de estudio en el mercado, más de 27 millones de copias vendidas, innumerables premios de primera categoría (Grammys, Brit Awards, NME Awards…), estadios agotados por el mundo entero e himnos generacionales de la talla de Everlong,The Pretender o The Best Of You, Foo Fighters es, a día de hoy, uno de los nombres más poderosos del rock moderno.', 'imgs/imgEvento/evento-61447679d32a9.jpg'),
(2, 'Bilbao Bilbao 2021', '2021-11-13 09:30:00', '2021-11-15 18:30:00', 1, 1, '2021-09-14 11:33:24', 'La Bilbao-Bilbao, la prueba cicloturista que reúne a 8.000 almas ciclistas por las carreteras vizcaínas  ya tiene nueva fecha para 2021: el domingo 26 de septiembre.\r\n\r\n«Esperemos que para entonces la situación sea diferente o haya ya una vacuna o tratamiento», deseó Philippe Govaert, miembro del comité organizador, después de haber tenido que tomar la decisión de cancelar la prueba en 2020 por la crisis del coronavirus. Meses después la organización aplazaba la tradicional fecha del 14 de marzo al 26 de septiembre por la crisis del coronavirus.', 'imgs/imgEvento/evento-6144775a7ad99.png'),
(3, 'EL MÉTODO GRONHÖLM', '2021-10-01 20:00:00', '2021-10-01 23:00:00', 1, 2, '2021-09-14 11:33:24', 'Regresa a Madrid uno de los éxitos teatrales más sonados de los últimos años, EL MÉTODO GRONHÖLM. Tamzin Townsend vuelve a dirigir esta diábolica comedia acerca de un peculiar método, que existe, acerca de cómo entrevistar a alguien para un puesto de trabajo. Luis Merlo, Marta Belenguer, Jorge Bosch e Ismael Martínez son las caras de esta versión.', NULL),
(5, 'Magia Infantil Magic Mickey', '2021-11-10 10:00:00', '2021-11-10 13:15:00', 1, 4, '2021-09-15 13:05:49', 'Especializado en magia infantil y familiar, desde 1993 con espectáculos interactivos y muy participativos, donde el público es involucrado en el show, colaborando con el mago, sintiendo así la Magia como nunca antes la habían sentido.\r\n\r\nLos más pequeños se sentirán protagonistas en el show, al colaborar con el mago a hacer que la magia fluya entre sus manos. Los amigos y familiares, también son involucrados en el show, siempre en un clima divertido y misterioso lleno de fantasía que hará que los invitados a su fiesta o celebracion, recuerden su evento como algo muy especial y mágico.', NULL),
(6, 'Planta tu árbol V edición', '2021-09-20 08:00:00', '2021-09-26 20:00:00', 1, 5, '2021-09-15 13:07:20', 'Excursiones diarias a maravillosos parajes naturales en los que podremos plantar nuestros árboles.', 'imgs/imgEvento/evento-61447957e1642.jpg'),
(7, 'Expoliva 2021', '2021-09-16 10:00:00', '2021-09-30 20:00:00', 1, 6, '2021-09-15 13:07:20', 'Expoliva 2021, la Feria Internacional del Aceite de Oliva e Industrias Afines se celebra del 22 al 25 de septiembre en Jaén, durante cuatro jornadas se podrá recorrer una gran feria de exposición comercial y asistir a los foros enmarcados en el Simposium Científico-Técnico. Es un evento en el que conocer la oferta comercial especializada, las novedades, las tecnologías, los servicios… y entre otras cosas, establecer y afianzar relaciones comerciales.', NULL),
(8, 'Euroliga: Barça-Madrid', '2021-12-10 09:00:00', '2021-12-10 23:00:00', 1, 1, '2021-09-16 10:46:45', 'la máxima competición de clubes de baloncesto de Europa. Disputada desde la temporada 2000-01 es organizada y controlada por la compañía privada Euroleague Basketball. En ella participan equipos de hasta 10 países diferentes miembros de FIBA Europa que provienen de un consorcio de las principales ligas profesionales de baloncesto de Europa, llamado Unión de Ligas Europeas de Baloncesto (ULEB).', 'imgs/imgEvento/evento-61447b1195376.jpg'),
(9, 'Viñarock 2022', '2022-04-28 00:00:00', '2022-04-30 00:00:00', 1, 3, '2021-09-16 13:15:13', 'El Viña Rock 2022 regresará a la localidad de Villarobledo, Albacete, del 28 al 30 de abril y como viene siendo habitual, el festival contará con una amplia zona de camping donde los asistentes al festival podrán descansar y hacer uso de duchas, baños, servicios de consigna, recarga de teléfonos móvil, etc.', 'imgs/imgEvento/evento-61447ba83ecb9.jpg'),
(11, 'Arte y mito. Los dioses del Prado', '2021-09-16 10:00:00', '2022-01-01 22:00:00', 1, 2, '2021-09-14 11:33:24', 'Se trata de una propuesta diacrónica, articulada en ocho secciones de carácter temático, que ofrece simultáneamente diferentes representaciones de dioses o distintas interpretaciones de un episodio mitológico para apreciar la riqueza iconográfica, geográfica y cronológica de las colecciones del Museo del Prado a través de 43 obras de autores esenciales de la historia del arte como Rubens, Ribera, o Zurbarán, entre muchos otros.', 'imgs/imgEvento/evento-61447ce925b6a.jpg'),
(12, 'Espectáculo de marionetas', '2021-09-20 11:00:00', '2021-09-20 14:00:00', 1, 4, '2021-09-14 11:33:24', 'En los sueños puede hacerse realidad aquello que más se desea.\r\nHe aquí que un niño teme que algún día sus padres se separen. A éste le gusta mucho un cuento, pero en el cual, el padre marcha lejos a trabajar durante mucho tiempo. Una noche, durmiendo y soñando con el cuento, arregla lo que le daba miedo. Un cuento dentro de una historia… y una historia dentro de un cuento.', 'imgs/imgEvento/evento-61447db0f3b6c.jpg'),
(13, 'Escalada en los Picos de Europa', '2021-10-08 08:00:00', '2021-10-10 18:00:00', 1, 5, '2021-09-17 10:33:56', 'Las rutas de escalada seleccionadas en esta guía se encuentran en su totalidad dentro de los límites de lo que es el Parque Nacional de los Picos de Europa. Éste abarca una zona muy amplia que lo mismo comprende amplias masas boscosas, ríos, pueblos o el terreno de la alta montaña. La guía se divide en sectores que atienden a un punto de salida concreto, desde el que se puede acceder a las rutas señaladas a continuación.', 'imgs/imgEvento/evento-61447e774febd.jpg'),
(14, 'San Sebastian Gastronomika', '2021-11-14 10:00:00', '2021-11-17 20:00:00', 1, 6, '2021-09-17 13:42:19', 'San Sebastián Gastronomika-Euskadi Basque Country, el decano mundial de los congresos gastronómicos, volverá del 4 al 6 de octubre al Kursaal adaptado a la nueva situación generada por la crisis de la Covid-19. Su XXIII edición mirará a Francia y planteará abrir un nuevo diálogo entre las cocinas francesa y española.', 'imgs/imgEvento/evento-61447f1b97699.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participante`
--

CREATE TABLE `participante` (
  `id` int(11) NOT NULL,
  `id_evento_id` int(11) NOT NULL,
  `id_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `participante`
--

INSERT INTO `participante` (`id`, `id_evento_id`, `id_usuario_id`) VALUES
(1, 1, 2),
(2, 1, 3),
(6, 13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `nombre`, `email`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$lWS8SlMLgdK5hLgw0FPpc.NBcWODtxFDNwqDDOt/1Hubgp2cF9/Wq', 'administrador', 'administrador@admin.es'),
(2, 'user1', '[\"ROLE_USER\"]\r\n', '$2y$13$eOIw2CHRM1xeqpb5ncoS9u3.5/SHpzpoNXIICZUzG4KBCs3ptwkyy', 'usuario1', 'usuario1@gmail.es'),
(3, 'user2', '[\"ROLE_USER\"]\r\n', 'user2', 'usuario2', 'usuario2@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B91E70279F37AE5` (`id_user_id`),
  ADD KEY `IDX_4B91E7027904465` (`id_evento_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_47860B0579F37AE5` (`id_user_id`),
  ADD KEY `IDX_47860B0510560508` (`id_categoria_id`);

--
-- Indices de la tabla `participante`
--
ALTER TABLE `participante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_85BDC5C37904465` (`id_evento_id`),
  ADD KEY `IDX_85BDC5C37EB2C349` (`id_usuario_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `participante`
--
ALTER TABLE `participante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `FK_4B91E7027904465` FOREIGN KEY (`id_evento_id`) REFERENCES `evento` (`id`),
  ADD CONSTRAINT `FK_4B91E70279F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `FK_47860B0510560508` FOREIGN KEY (`id_categoria_id`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `FK_47860B0579F37AE5` FOREIGN KEY (`id_user_id`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `participante`
--
ALTER TABLE `participante`
  ADD CONSTRAINT `FK_85BDC5C37904465` FOREIGN KEY (`id_evento_id`) REFERENCES `evento` (`id`),
  ADD CONSTRAINT `FK_85BDC5C37EB2C349` FOREIGN KEY (`id_usuario_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
