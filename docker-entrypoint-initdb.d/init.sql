-- ============================================================
-- EnglishAcademy - Full database initialization script
-- Database: englishacademy
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- Create and select database
-- ------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `englishacademy`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `englishacademy`;

-- ============================================================
-- Table: cache
-- ============================================================
CREATE TABLE IF NOT EXISTS `cache` (
  `key`        varchar(255)  NOT NULL,
  `value`      mediumtext    NOT NULL,
  `expiration` int           NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: cache_locks
-- ============================================================
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key`        varchar(255) NOT NULL,
  `owner`      varchar(255) NOT NULL,
  `expiration` int          NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: jobs
-- ============================================================
CREATE TABLE IF NOT EXISTS `jobs` (
  `id`           bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue`        varchar(255)    NOT NULL,
  `payload`      longtext        NOT NULL,
  `attempts`     tinyint unsigned NOT NULL,
  `reserved_at`  int unsigned    DEFAULT NULL,
  `available_at` int unsigned    NOT NULL,
  `created_at`   int unsigned    NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: job_batches
-- ============================================================
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id`             varchar(255) NOT NULL,
  `name`           varchar(255) NOT NULL,
  `total_jobs`     int          NOT NULL,
  `pending_jobs`   int          NOT NULL,
  `failed_jobs`    int          NOT NULL,
  `failed_job_ids` longtext     NOT NULL,
  `options`        mediumtext   DEFAULT NULL,
  `cancelled_at`   int          DEFAULT NULL,
  `created_at`     int          NOT NULL,
  `finished_at`    int          DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: failed_jobs
-- ============================================================
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid`       varchar(255)    NOT NULL,
  `connection` text            NOT NULL,
  `queue`      text            NOT NULL,
  `payload`    longtext        NOT NULL,
  `exception`  longtext        NOT NULL,
  `failed_at`  timestamp       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: clases
-- (created before users because users has a FK to clases)
-- ============================================================
CREATE TABLE IF NOT EXISTS `clases` (
  `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre`      varchar(100)    NOT NULL,
  `nivel`       enum('b1','b2','c1') NOT NULL,
  `codigo`      varchar(20)     NOT NULL,
  `profesor_id` bigint unsigned DEFAULT NULL,
  `created_at`  timestamp       NULL DEFAULT NULL,
  `updated_at`  timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clases_codigo_unique` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: users
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id`                bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre`            varchar(30)     NOT NULL,
  `email`             varchar(255)    NOT NULL,
  `email_verified_at` timestamp       NULL DEFAULT NULL,
  `password`          varchar(255)    NOT NULL,
  `remember_token`    varchar(100)    DEFAULT NULL,
  `rol`               enum('alumno','profesor') NOT NULL,
  `nivel`             enum('b1','b2','c1')      NOT NULL,
  `clase_id`          bigint unsigned NOT NULL,
  `created_at`        timestamp       NULL DEFAULT NULL,
  `updated_at`        timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_clase_id_foreign` (`clase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: sessions
-- ============================================================
CREATE TABLE IF NOT EXISTS `sessions` (
  `id`            varchar(255)    NOT NULL,
  `user_id`       bigint unsigned DEFAULT NULL,
  `ip_address`    varchar(45)     DEFAULT NULL,
  `user_agent`    text            DEFAULT NULL,
  `payload`       longtext        NOT NULL,
  `last_activity` int             NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: mensajes
-- ============================================================
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id`    bigint unsigned NOT NULL,
  `mensaje`    text            NOT NULL,
  `clase_id`   bigint unsigned NOT NULL,
  `created_at` timestamp       NULL DEFAULT NULL,
  `updated_at` timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mensajes_user_id_foreign`  (`user_id`),
  KEY `mensajes_clase_id_foreign` (`clase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: cuestionarios
-- ============================================================
CREATE TABLE IF NOT EXISTS `cuestionarios` (
  `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
  `titulo`      varchar(200)    NOT NULL,
  `descripcion` text            DEFAULT NULL,
  `clase_id`    bigint unsigned NOT NULL,
  `profesor_id` bigint unsigned NOT NULL,
  `tipo`        enum('gramatica','vocabulario','listening','reading') NOT NULL,
  `created_at`  timestamp       NULL DEFAULT NULL,
  `updated_at`  timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cuestionarios_clase_id_foreign`    (`clase_id`),
  KEY `cuestionarios_profesor_id_foreign` (`profesor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: preguntas
-- ============================================================
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id`              bigint unsigned NOT NULL AUTO_INCREMENT,
  `pregunta`        text            NOT NULL,
  `audio`           varchar(255)    DEFAULT NULL,
  `cuestionario_id` bigint unsigned NOT NULL,
  `created_at`      timestamp       NULL DEFAULT NULL,
  `updated_at`      timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `preguntas_cuestionario_id_foreign` (`cuestionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: opciones
-- ============================================================
CREATE TABLE IF NOT EXISTS `opciones` (
  `id`          bigint unsigned NOT NULL AUTO_INCREMENT,
  `opcion`      text            NOT NULL,
  `es_correcta` tinyint(1)      NOT NULL DEFAULT 0,
  `pregunta_id` bigint unsigned NOT NULL,
  `created_at`  timestamp       NULL DEFAULT NULL,
  `updated_at`  timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `opciones_pregunta_id_foreign` (`pregunta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: resultados
-- ============================================================
CREATE TABLE IF NOT EXISTS `resultados` (
  `id`                  bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id`             bigint unsigned NOT NULL,
  `cuestionario_id`     bigint unsigned NOT NULL,
  `puntuacion_obtenida` int             NOT NULL DEFAULT 0,
  `respuestas`          json            DEFAULT NULL,
  `created_at`          timestamp       NULL DEFAULT NULL,
  `updated_at`          timestamp       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resultados_user_id_foreign`         (`user_id`),
  KEY `resultados_cuestionario_id_foreign` (`cuestionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: migrations
-- ============================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id`        int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch`     int          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Foreign key constraints
-- (added after all tables exist to avoid ordering issues)
-- ============================================================

ALTER TABLE `clases`
  ADD CONSTRAINT `clases_profesor_id_foreign`
    FOREIGN KEY (`profesor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `users`
  ADD CONSTRAINT `users_clase_id_foreign`
    FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE SET NULL;

ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_user_id_foreign`
    FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `mensajes_clase_id_foreign`
    FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE RESTRICT;

ALTER TABLE `cuestionarios`
  ADD CONSTRAINT `cuestionarios_clase_id_foreign`
    FOREIGN KEY (`clase_id`)    REFERENCES `clases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuestionarios_profesor_id_foreign`
    FOREIGN KEY (`profesor_id`) REFERENCES `users`  (`id`) ON DELETE CASCADE;

ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_cuestionario_id_foreign`
    FOREIGN KEY (`cuestionario_id`) REFERENCES `cuestionarios` (`id`) ON DELETE CASCADE;

ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_pregunta_id_foreign`
    FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`) ON DELETE CASCADE;

ALTER TABLE `resultados`
  ADD CONSTRAINT `resultados_user_id_foreign`
    FOREIGN KEY (`user_id`)         REFERENCES `users`         (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resultados_cuestionario_id_foreign`
    FOREIGN KEY (`cuestionario_id`) REFERENCES `cuestionarios` (`id`) ON DELETE CASCADE;

-- ============================================================
-- Seed data
-- ============================================================

-- ------------------------------------------------------------
-- clases  (inserted before users so FK is satisfied)
-- profesor_id is NULL initially; updated after users are inserted
-- ------------------------------------------------------------
INSERT INTO `clases` (`id`, `nombre`, `nivel`, `codigo`, `profesor_id`, `created_at`, `updated_at`) VALUES
(1, 'Intensivo B1', 'b1', '1', NULL, NOW(), NOW()),
(2, 'Intensivo B2', 'b2', '2', NULL, NOW(), NOW()),
(3, 'Intensivo C1', 'c1', '3', NULL, NOW(), NOW());

-- ------------------------------------------------------------
-- users
-- Passwords are bcrypt hashes of 'password'
-- ------------------------------------------------------------
INSERT INTO `users` (`id`, `nombre`, `email`, `email_verified_at`, `password`, `remember_token`, `rol`, `nivel`, `clase_id`, `created_at`, `updated_at`) VALUES
(1, 'rosa lopez', 'rosa@example.com',  NULL, '$2y$12$eImiTXuWVxfM37uY4JANjQ==.hashed.placeholder', NULL, 'profesor', 'b1', 1, NOW(), NOW()),
(2, 'jose',       'jose@example.com',  NULL, '$2y$12$eImiTXuWVxfM37uY4JANjQ==.hashed.placeholder', NULL, 'alumno',   'b1', 1, NOW(), NOW()),
(3, 'Marta',      'marta@example.com', NULL, '$2y$12$eImiTXuWVxfM37uY4JANjQ==.hashed.placeholder', NULL, 'alumno',   'b2', 2, NOW(), NOW());

-- Assign professor to their class
UPDATE `clases` SET `profesor_id` = 1 WHERE `id` = 1;

-- ------------------------------------------------------------
-- cuestionarios
-- ------------------------------------------------------------
INSERT INTO `cuestionarios` (`id`, `titulo`, `descripcion`, `clase_id`, `profesor_id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Past simple',                   'Test your knowledge of the past simple tense.',  1, 1, 'gramatica',   NOW(), NOW()),
(2, 'Basic English Vocabulary Quiz', 'Test your basic English vocabulary knowledge.',   2, 1, 'vocabulario', NOW(), NOW());

-- ------------------------------------------------------------
-- preguntas  (5 per cuestionario)
-- ------------------------------------------------------------
INSERT INTO `preguntas` (`id`, `pregunta`, `audio`, `cuestionario_id`, `created_at`, `updated_at`) VALUES
-- Cuestionario 1: Past simple
(1,  'What is the past simple form of "go"?',                                NULL, 1, NOW(), NOW()),
(2,  'Which sentence is in the past simple tense?',                          NULL, 1, NOW(), NOW()),
(3,  'What is the past simple form of "have"?',                              NULL, 1, NOW(), NOW()),
(4,  'Choose the correct past simple form: "She ___ to the store yesterday."', NULL, 1, NOW(), NOW()),
(5,  'What is the past simple form of "be" (third person singular)?',        NULL, 1, NOW(), NOW()),
-- Cuestionario 2: Basic English Vocabulary Quiz
(6,  'What does "apple" mean?',                                              NULL, 2, NOW(), NOW()),
(7,  'Which word means the opposite of "big"?',                              NULL, 2, NOW(), NOW()),
(8,  'What is the correct word for a place where you sleep?',                NULL, 2, NOW(), NOW()),
(9,  'Which word describes the color of the sky on a clear day?',            NULL, 2, NOW(), NOW()),
(10, 'What does "run" mean?',                                                NULL, 2, NOW(), NOW());

-- ------------------------------------------------------------
-- opciones  (4 per pregunta; one marked es_correcta = 1)
-- ------------------------------------------------------------
INSERT INTO `opciones` (`id`, `opcion`, `es_correcta`, `pregunta_id`, `created_at`, `updated_at`) VALUES
-- Pregunta 1
(1,  'went',    1, 1, NOW(), NOW()),
(2,  'goed',    0, 1, NOW(), NOW()),
(3,  'gone',    0, 1, NOW(), NOW()),
(4,  'going',   0, 1, NOW(), NOW()),
-- Pregunta 2
(5,  'She walks to school every day.',  0, 2, NOW(), NOW()),
(6,  'She walked to school yesterday.', 1, 2, NOW(), NOW()),
(7,  'She will walk to school.',        0, 2, NOW(), NOW()),
(8,  'She is walking to school.',       0, 2, NOW(), NOW()),
-- Pregunta 3
(9,  'had',   1, 3, NOW(), NOW()),
(10, 'haved', 0, 3, NOW(), NOW()),
(11, 'has',   0, 3, NOW(), NOW()),
(12, 'have',  0, 3, NOW(), NOW()),
-- Pregunta 4
(13, 'go',   0, 4, NOW(), NOW()),
(14, 'went', 1, 4, NOW(), NOW()),
(15, 'gone', 0, 4, NOW(), NOW()),
(16, 'goes', 0, 4, NOW(), NOW()),
-- Pregunta 5
(17, 'was',  1, 5, NOW(), NOW()),
(18, 'were', 0, 5, NOW(), NOW()),
(19, 'is',   0, 5, NOW(), NOW()),
(20, 'be',   0, 5, NOW(), NOW()),
-- Pregunta 6
(21, 'A fruit',    1, 6, NOW(), NOW()),
(22, 'A vegetable',0, 6, NOW(), NOW()),
(23, 'An animal',  0, 6, NOW(), NOW()),
(24, 'A color',    0, 6, NOW(), NOW()),
-- Pregunta 7
(25, 'small', 1, 7, NOW(), NOW()),
(26, 'tall',  0, 7, NOW(), NOW()),
(27, 'fast',  0, 7, NOW(), NOW()),
(28, 'heavy', 0, 7, NOW(), NOW()),
-- Pregunta 8
(29, 'bedroom',  1, 8, NOW(), NOW()),
(30, 'kitchen',  0, 8, NOW(), NOW()),
(31, 'bathroom', 0, 8, NOW(), NOW()),
(32, 'garage',   0, 8, NOW(), NOW()),
-- Pregunta 9
(33, 'blue',   1, 9, NOW(), NOW()),
(34, 'green',  0, 9, NOW(), NOW()),
(35, 'red',    0, 9, NOW(), NOW()),
(36, 'yellow', 0, 9, NOW(), NOW()),
-- Pregunta 10
(37, 'To move quickly on foot', 1, 10, NOW(), NOW()),
(38, 'To sleep',                0, 10, NOW(), NOW()),
(39, 'To eat',                  0, 10, NOW(), NOW()),
(40, 'To swim',                 0, 10, NOW(), NOW());

-- ------------------------------------------------------------
-- resultados
-- ------------------------------------------------------------
INSERT INTO `resultados` (`id`, `user_id`, `cuestionario_id`, `puntuacion_obtenida`, `respuestas`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 4, '{"1":1,"2":6,"3":9,"4":14,"5":17}',  NOW(), NOW()),
(2, 3, 2, 3, '{"6":21,"7":25,"8":30,"9":33,"10":37}', NOW(), NOW());

-- ------------------------------------------------------------
-- mensajes
-- ------------------------------------------------------------
INSERT INTO `mensajes` (`id`, `user_id`, `mensaje`, `clase_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bienvenidos a la clase de Inglés Intensivo B1. Por favor, completad el cuestionario de Past Simple antes del viernes.', 1, NOW(), NOW()),
(2, 2, 'Profesora, ¿el cuestionario incluye verbos irregulares?', 1, NOW(), NOW()),
(3, 1, 'Sí, incluye los verbos irregulares más comunes. ¡Ánimo!', 1, NOW(), NOW()),
(4, 3, 'Hola a todos, ¿alguien puede ayudarme con el vocabulario de la unidad 3?', 2, NOW(), NOW());

-- ------------------------------------------------------------
-- migrations  (so Laravel skips running them again)
-- ------------------------------------------------------------
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,  '0001_01_01_000001_create_cache_table',          1),
(2,  '0001_01_01_000002_create_jobs_table',           1),
(3,  '0001_01_01_000003_clases_tabla',                1),
(4,  '0001_01_01_000004_users_tabla',                 1),
(5,  '0001_01_01_000005_mensajes_tabla',              1),
(6,  '2026_02_05_105203_cuestionarios_tabla',         1),
(7,  '2026_02_06_170737_preguntas_tabla',             1),
(8,  '2026_02_06_170745_opciones_tabla',              1),
(9,  '2026_02_06_170831_resultados_tabla',            1),
(10, '2026_03_29_112601_create_sessions_table',       1);

SET FOREIGN_KEY_CHECKS = 1;
