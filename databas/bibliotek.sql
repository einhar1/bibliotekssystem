-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1:3306
-- Tid vid skapande: 25 jan 2023 kl 13:43
-- Serverversion: 5.7.36
-- PHP-version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `bibliotek`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `böcker`
--

DROP TABLE IF EXISTS `böcker`;
CREATE TABLE IF NOT EXISTS `böcker` (
  `streckkodsnr_pk` int(255) NOT NULL AUTO_INCREMENT,
  `ISBN` bigint(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'tillgänglig',
  PRIMARY KEY (`streckkodsnr_pk`)
) ENGINE=MyISAM AUTO_INCREMENT=98765492 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `böcker`
--

INSERT INTO `böcker` (`streckkodsnr_pk`, `ISBN`, `status`) VALUES
(98765433, 9781338321913, 'utlånad'),
(98765490, 9789163965197, 'tillgänglig'),
(98765435, 9780702300172, 'utlånad'),
(98765436, 9789113073743, 'utlånad'),
(98765437, 9789127455771, 'tillgänglig'),
(98765438, 9789197677028, 'tillgänglig'),
(98765439, 9789188171887, 'utlånad'),
(98765440, 9789175036465, 'tillgänglig'),
(98765442, 9789127455771, 'tillgänglig'),
(98765445, 9780702300172, 'utlånad'),
(98765446, 9781338321913, 'tillgänglig'),
(98765447, 9789175036465, 'tillgänglig'),
(98765448, 9781338321913, 'tillgänglig'),
(98765449, 9789176210871, 'tillgänglig'),
(98765450, 9789157030146, 'utlånad'),
(98765451, 9781338321913, 'utlånad'),
(98765452, 9789175036465, 'tillgänglig'),
(98765453, 9789175036465, 'utlånad'),
(98765454, 9781338321913, 'tillgänglig'),
(98765455, 9781338321913, 'utlånad'),
(98765456, 9781471166204, 'tillgänglig'),
(98765457, 9789186289485, 'tillgänglig'),
(98765458, 9789173154468, 'utlånad'),
(98765459, 9789129675566, 'tillgänglig'),
(98765460, 9789163820755, 'tillgänglig'),
(98765491, 9789147106721, 'tillgänglig'),
(98765462, 9789129675351, 'utlånad'),
(98765463, 9789163838101, 'tillgänglig'),
(98765464, 9789129675351, 'tillgänglig'),
(98765465, 9789173154468, 'tillgänglig'),
(98765466, 9789147106721, 'tillgänglig'),
(98765467, 9789147106721, 'tillgänglig'),
(98765468, 9789147106721, 'tillgänglig'),
(98765469, 9789175039688, 'tillgänglig'),
(98765470, 9789175039688, 'tillgänglig'),
(98765472, 9789163965197, 'tillgänglig'),
(98765473, 9789163965197, 'tillgänglig'),
(98765489, 9789171341419, 'tillgänglig'),
(98765475, 9789175036465, 'tillgänglig'),
(98765476, 9789175036465, 'tillgänglig'),
(98765483, 9789178038428, 'tillgänglig'),
(98765482, 9789178038428, 'tillgänglig'),
(98765481, 9789178038428, 'tillgänglig'),
(98765480, 9789127455771, 'tillgänglig'),
(98765487, 9789171340689, 'tillgänglig'),
(98765488, 9789171341419, 'tillgänglig');

-- --------------------------------------------------------

--
-- Tabellstruktur `låntagare`
--

DROP TABLE IF EXISTS `låntagare`;
CREATE TABLE IF NOT EXISTS `låntagare` (
  `lånekortsnr_pk` int(255) NOT NULL AUTO_INCREMENT,
  `namn` varchar(255) NOT NULL,
  `pin` int(255) NOT NULL,
  `roll` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`lånekortsnr_pk`)
) ENGINE=MyISAM AUTO_INCREMENT=12345681 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `låntagare`
--

INSERT INTO `låntagare` (`lånekortsnr_pk`, `namn`, `pin`, `roll`) VALUES
(12345678, 'Einar Harri', 1234, 'admin'),
(12345679, 'Daniel Andersson', 5678, 'user'),
(12345680, 'Anita Harri', 9012, 'user');

-- --------------------------------------------------------

--
-- Tabellstruktur `utlån`
--

DROP TABLE IF EXISTS `utlån`;
CREATE TABLE IF NOT EXISTS `utlån` (
  `id_pk` int(255) NOT NULL AUTO_INCREMENT,
  `streckkodsnr_fk` bigint(255) NOT NULL,
  `lånekortsnr_fk` bigint(255) NOT NULL,
  `utlåningsdatum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pk`)
) ENGINE=MyISAM AUTO_INCREMENT=1020 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `utlån`
--

INSERT INTO `utlån` (`id_pk`, `streckkodsnr_fk`, `lånekortsnr_fk`, `utlåningsdatum`) VALUES
(1006, 98765453, 12345679, '2023-01-14 16:19:19'),
(1005, 98765450, 12345679, '2023-01-14 16:19:19'),
(1008, 98765433, 12345678, '2023-01-14 16:19:19'),
(1009, 98765458, 12345680, '2023-01-14 16:19:19'),
(1007, 98765435, 12345678, '2023-01-14 16:19:19'),
(1001, 98765436, 12345678, '2023-01-14 16:19:19'),
(1011, 98765439, 12345680, '2023-01-14 16:19:19'),
(1012, 98765455, 12345678, '2023-01-14 16:28:02'),
(1013, 98765451, 12345678, '2023-01-17 11:40:00'),
(1019, 98765445, 12345678, '2023-01-24 12:10:43'),
(1018, 98765462, 12345678, '2023-01-17 11:42:29');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
