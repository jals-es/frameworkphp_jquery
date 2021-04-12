
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

create database IF NOT EXISTS clase_crud;
use clase_appbar;

CREATE TABLE IF NOT EXISTS `productos` (
  `cod_prod` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `type` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ingredientes` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `precio` decimal(65,2) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(2) NOT NULL,
  `img` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`cod_prod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `categorias` (
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `img` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `locales` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `lng` decimal(65,38) COLLATE utf8_spanish_ci NOT NULL,
  `lat` decimal(65,38) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `visitas_prod` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_user` int(255) NOT NULL,
  `id_prod` int(255) NOT NULL,
  `ip` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;