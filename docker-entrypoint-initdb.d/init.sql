-- ============================================================
-- EnglishAcademy — MySQL initialization script
-- Automatically executed by MySQL on first container start.
-- ============================================================

CREATE DATABASE IF NOT EXISTS `english_academy`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `english_academy`;

-- ------------------------------------------------------------
-- Disable FK checks while building the schema
-- ------------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- Table: cache
-- ============================================================
CREATE TABLE IF NOT EXISTS `cache` (
  `key`        VARCHAR(255) NOT NULL,
  `value`      MEDIUMTEXT   NOT NULL,
  `expiration` INT          NOT NULL,
  PRIMARY KEY (`key`),
  INDEX `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: cache_locks
-- ============================================================
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key`        VARCHAR(255) NOT NULL,
  `owner`      VARCHAR(255) NOT NULL,
  `expiration` INT          NOT NULL,
  PRIMARY KEY (`key`),
  INDEX `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: jobs
-- ============================================================
CREATE TABLE IF NOT EXISTS `jobs` (
  `id`           BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `queue`        VARCHAR(255)     NOT NULL,
  `payload`      LONGTEXT         NOT NULL,
  `attempts`     TINYINT UNSIGNED NOT NULL,
  `reserved_at`  INT UNSIGNED     NULL,
  `available_at` INT UNSIGNED     NOT NULL,
  `created_at`   INT UNSIGNED     NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: job_batches
-- ============================================================
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id`             VARCHAR(255) NOT NULL,
  `name`           VARCHAR(255) NOT NULL,
  `total_jobs`     INT          NOT NULL,
  `pending_jobs`   INT          NOT NULL,
  `failed_jobs`    INT          NOT NULL,
  `failed_job_ids` LONGTEXT     NOT NULL,
  `options`        MEDIUMTEXT   NULL,
  `cancelled_at`   INT          NULL,
  `created_at`     INT          NOT NULL,
  `finished_at`    INT          NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: failed_jobs
-- ============================================================
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid`       VARCHAR(255)    NOT NULL,
  `connection` TEXT            NOT NULL,
  `queue`      TEXT            NOT NULL,
  `payload`    LONGTEXT        NOT NULL,
  `exception`  LONGTEXT        NOT NULL,
  `failed_at`  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: clases
-- (created before users because users.clase_id references it)
-- ============================================================
CREATE TABLE IF NOT EXISTS `clases` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre`      VARCHAR(100)    NOT NULL,
  `nivel`       ENUM('b1','b2','c1') NOT NULL,
  `codigo`      VARCHAR(20)     NOT NULL,
  `profesor_id` BIGINT UNSIGNED NULL,
  `created_at`  TIMESTAMP       NULL,
  `updated_at`  TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clases_codigo_unique` (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: users
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id`                BIGINT UNSIGNED      NOT NULL AUTO_INCREMENT,
  `nombre`            VARCHAR(30)          NOT NULL,
  `email`             VARCHAR(255)         NOT NULL,
  `email_verified_at` TIMESTAMP            NULL,
  `password`          VARCHAR(255)         NOT NULL,
  `remember_token`    VARCHAR(100)         NULL,
  `rol`               ENUM('alumno','profesor') NOT NULL,
  `nivel`             ENUM('b1','b2','c1') NOT NULL,
  `clase_id`          BIGINT UNSIGNED      NOT NULL,
  `created_at`        TIMESTAMP            NULL,
  `updated_at`        TIMESTAMP            NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  INDEX `users_clase_id_foreign` (`clase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: mensajes
-- ============================================================
CREATE TABLE IF NOT EXISTS `mensajes` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    BIGINT UNSIGNED NOT NULL,
  `mensaje`    TEXT            NOT NULL,
  `clase_id`   BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP       NULL,
  `updated_at` TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  INDEX `mensajes_user_id_foreign`  (`user_id`),
  INDEX `mensajes_clase_id_foreign` (`clase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: cuestionarios
-- ============================================================
CREATE TABLE IF NOT EXISTS `cuestionarios` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `titulo`      VARCHAR(200)    NOT NULL,
  `descripcion` TEXT            NULL,
  `clase_id`    BIGINT UNSIGNED NOT NULL,
  `profesor_id` BIGINT UNSIGNED NOT NULL,
  `tipo`        ENUM('gramatica','vocabulario','listening','reading') NOT NULL,
  `created_at`  TIMESTAMP       NULL,
  `updated_at`  TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  INDEX `cuestionarios_clase_id_foreign`    (`clase_id`),
  INDEX `cuestionarios_profesor_id_foreign` (`profesor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: preguntas
-- ============================================================
CREATE TABLE IF NOT EXISTS `preguntas` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pregunta`         TEXT            NOT NULL,
  `audio`            VARCHAR(255)    NULL,
  `cuestionario_id`  BIGINT UNSIGNED NOT NULL,
  `created_at`       TIMESTAMP       NULL,
  `updated_at`       TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  INDEX `preguntas_cuestionario_id_foreign` (`cuestionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: opciones
-- ============================================================
CREATE TABLE IF NOT EXISTS `opciones` (
  `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `opcion`      TEXT            NOT NULL,
  `es_correcta` TINYINT(1)      NOT NULL DEFAULT 0,
  `pregunta_id` BIGINT UNSIGNED NOT NULL,
  `created_at`  TIMESTAMP       NULL,
  `updated_at`  TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  INDEX `opciones_pregunta_id_foreign` (`pregunta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: resultados
-- ============================================================
CREATE TABLE IF NOT EXISTS `resultados` (
  `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`             BIGINT UNSIGNED NOT NULL,
  `cuestionario_id`     BIGINT UNSIGNED NOT NULL,
  `puntuacion_obtenida` INT             NOT NULL DEFAULT 0,
  `respuestas`          JSON            NULL,
  `created_at`          TIMESTAMP       NULL,
  `updated_at`          TIMESTAMP       NULL,
  PRIMARY KEY (`id`),
  INDEX `resultados_user_id_foreign`         (`user_id`),
  INDEX `resultados_cuestionario_id_foreign` (`cuestionario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: sessions
-- ============================================================
CREATE TABLE IF NOT EXISTS `sessions` (
  `id`            VARCHAR(255)    NOT NULL,
  `user_id`       BIGINT UNSIGNED NULL,
  `ip_address`    VARCHAR(45)     NULL,
  `user_agent`    TEXT            NULL,
  `payload`       LONGTEXT        NOT NULL,
  `last_activity` INT             NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `sessions_user_id_index`       (`user_id`),
  INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Table: migrations  (Laravel migration tracking)
-- ============================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch`     INT          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Foreign key constraints
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
-- Seed data: clases (from ClaseSeeder)
-- ============================================================
INSERT INTO `clases` (`id`, `nombre`, `nivel`, `codigo`, `profesor_id`, `created_at`, `updated_at`) VALUES
  (1, 'Intensivo B1', 'b1', '1', NULL, NOW(), NOW()),
  (2, 'Intensivo B2', 'b2', '2', NULL, NOW(), NOW()),
  (3, 'Intensivo C1', 'c1', '3', NULL, NOW(), NOW());

-- ============================================================
-- Seed data: migrations (marks all migrations as run so
-- `php artisan migrate` does not re-run them)
-- ============================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
  ('0001_01_01_000001_create_cache_table',              1),
  ('0001_01_01_000002_create_jobs_table',               1),
  ('0001_01_01_000003_clases_tabla',                    1),
  ('0001_01_01_000004_users_tabla',                     1),
  ('0001_01_01_000005_mensajes_tabla',                  1),
  ('2026_02_05_105203_cuestionarios_tabla',             1),
  ('2026_02_06_170737_preguntas_tabla',                 1),
  ('2026_02_06_170745_opciones_tabla',                  1),
  ('2026_02_06_170831_resultados_tabla',                1),
  ('2026_03_29_112601_create_sessions_table',           1);

-- ------------------------------------------------------------
-- Re-enable FK checks
-- ------------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 1;
