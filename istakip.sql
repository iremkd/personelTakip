-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 07 Tem 2023, 09:06:43
-- Sunucu sürümü: 8.0.31
-- PHP Sürümü: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `istakip`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `isciler`
--

DROP TABLE IF EXISTS `isciler`;
CREATE TABLE IF NOT EXISTS `isciler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `adsoyad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `cep` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `dtarih` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `durum` int NOT NULL DEFAULT '0',
  `verilenis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `isciler`
--

INSERT INTO `isciler` (`id`, `adsoyad`, `cep`, `dtarih`, `durum`, `verilenis`) VALUES
(17, 'beyza nur haktanır', '(555)-555-5555', '2022-12-28', 0, ''),
(18, 'ilker keskin', '(444)-444-4444', '2021-09-21', 1, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `isler`
--

DROP TABLE IF EXISTS `isler`;
CREATE TABLE IF NOT EXISTS `isler` (
  `id` int NOT NULL AUTO_INCREMENT,
  `isadi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `starih` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `atanan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `durum` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `isler`
--

INSERT INTO `isler` (`id`, `isadi`, `starih`, `atanan`, `durum`) VALUES
(71, 'tasarım', '2023-07-14', '17', 2),
(72, 'tasarım', '2023-07-13', '18', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
