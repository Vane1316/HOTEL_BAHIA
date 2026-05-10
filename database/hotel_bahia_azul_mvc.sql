SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

DROP DATABASE IF EXISTS `hotel_bahia_azul_mvc`;
CREATE DATABASE `hotel_bahia_azul_mvc` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `hotel_bahia_azul_mvc`;

CREATE TABLE `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre_completo` VARCHAR(120) NOT NULL,
  `usuario` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `rol` ENUM('administrador','recepcion','ventas') NOT NULL DEFAULT 'recepcion',
  `estado` ENUM('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `habitaciones` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `numero` VARCHAR(20) NOT NULL UNIQUE,
  `tipo` VARCHAR(60) NOT NULL,
  `capacidad` INT NOT NULL,
  `precio_noche` DECIMAL(12,2) NOT NULL,
  `estado` ENUM('disponible','ocupada','mantenimiento','limpieza','deshabilitada') NOT NULL DEFAULT 'disponible',
  `descripcion` TEXT,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `paquetes_habitacion` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `descripcion` TEXT,
  `incluye` TEXT,
  `precio` DECIMAL(12,2) NOT NULL,
  `estado` ENUM('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `reservas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario_id` INT NOT NULL,
  `habitacion_id` INT NOT NULL,
  `paquete_id` INT DEFAULT NULL,
  `cliente_nombre` VARCHAR(120) NOT NULL,
  `cliente_documento` VARCHAR(40) NOT NULL,
  `cliente_telefono` VARCHAR(40) NOT NULL,
  `fecha_reserva` DATE NOT NULL,
  `fecha_entrada` DATE NOT NULL,
  `fecha_salida` DATE NOT NULL,
  `cantidad_personas` INT NOT NULL,
  `tipo_pago` ENUM('efectivo','tarjeta','transferencia') NOT NULL,
  `precio_noche` DECIMAL(12,2) NOT NULL,
  `precio_paquete` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `total_reserva` DECIMAL(12,2) NOT NULL,
  `estado_reserva` ENUM('pendiente','confirmada','cancelada','finalizada') NOT NULL DEFAULT 'pendiente',
  `observaciones` TEXT,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`),
  CONSTRAINT `fk_reserva_habitacion` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones`(`id`),
  CONSTRAINT `fk_reserva_paquete` FOREIGN KEY (`paquete_id`) REFERENCES `paquetes_habitacion`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`nombre_completo`,`usuario`,`email`,`password`,`rol`,`estado`) VALUES
('Administrador General','admin','admin@bahiaazul.local','$2y$10$VPOvoNTkVY4mNcV5w3vrwu7ZjLUFGzYwPMAQDRIazQ8oM1u8D1jCi','administrador','activo'),
('Laura Recepción','recepcion','recepcion@bahiaazul.local','$2y$10$KsLQY0fdfEPM0A3R3FK1/e5UPHjMwy5j8ax4Fi4BfSx2RXtB7Xv.O','recepcion','activo'),
('Mario Ventas','ventas','ventas@bahiaazul.local','$2y$10$8ZhJka7qgnl3BBo8iz8/c.3c3eLQ1D0eYzR6SgL4oQ6gR9r63oXDa','ventas','inactivo');

INSERT INTO `habitaciones` (`numero`,`tipo`,`capacidad`,`precio_noche`,`estado`,`descripcion`) VALUES
('101','Sencilla',2,180000,'disponible','Cama doble, TV y baño privado.'),
('102','Doble',4,260000,'limpieza','Ideal para familia.'),
('201','Suite',2,420000,'mantenimiento','Suite con sala auxiliar.'),
('202','Ejecutiva',2,310000,'deshabilitada','Bloqueada temporalmente.'),
('301','Familiar',5,390000,'ocupada','Habitación amplia para grupo.');

INSERT INTO `paquetes_habitacion` (`nombre`,`descripcion`,`incluye`,`precio`,`estado`) VALUES
('Solo hospedaje','Plan base sin extras','Alojamiento por noche',0,'activo'),
('Plan desayuno','Incluye desayuno buffet','Hospedaje + desayuno + café de bienvenida',45000,'activo'),
('Plan romántico','Decoración especial y cena','Hospedaje + cena + decoración + vino',180000,'activo'),
('Plan ejecutivo','Traslado y desayuno temprano','Hospedaje + desayuno + transporte aeropuerto',120000,'activo');

INSERT INTO `reservas` (`usuario_id`,`habitacion_id`,`paquete_id`,`cliente_nombre`,`cliente_documento`,`cliente_telefono`,`fecha_reserva`,`fecha_entrada`,`fecha_salida`,`cantidad_personas`,`tipo_pago`,`precio_noche`,`precio_paquete`,`total_reserva`,`estado_reserva`,`observaciones`) VALUES
(1,1,2,'Camila Ortega','CC100200300','3001112233','2026-03-10','2026-04-05','2026-04-07',2,'tarjeta',180000,45000,405000,'confirmada','Solicita check-in temprano.'),
(2,5,3,'Familia Pérez','CC900800700','3015556677','2026-03-11','2026-04-10','2026-04-12',4,'transferencia',390000,180000,960000,'pendiente','Necesitan cama auxiliar.'),
(1,2,1,'Jorge Salas','CC555444333','3022223344','2026-03-12','2026-04-15','2026-04-16',2,'efectivo',260000,0,260000,'finalizada','Sin novedades.');

COMMIT;
