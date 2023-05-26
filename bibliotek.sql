-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1:3306
-- Tid vid skapande: 26 maj 2023 kl 15:39
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
-- Tabellstruktur `adminlösen`
--

DROP TABLE IF EXISTS `adminlösen`;
CREATE TABLE IF NOT EXISTS `adminlösen` (
  `lösenord` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `adminlösen`
--

INSERT INTO `adminlösen` (`lösenord`) VALUES
('teknik123');

-- --------------------------------------------------------

--
-- Tabellstruktur `böcker`
--

DROP TABLE IF EXISTS `böcker`;
CREATE TABLE IF NOT EXISTS `böcker` (
  `streckkodsnr_pk` int(255) NOT NULL AUTO_INCREMENT,
  `ISBN` bigint(255) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'tillgänglig',
  PRIMARY KEY (`streckkodsnr_pk`)
) ENGINE=MyISAM AUTO_INCREMENT=98766136 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `böcker`
--

INSERT INTO `böcker` (`streckkodsnr_pk`, `ISBN`, `titel`, `identifier`, `status`) VALUES
(98766091, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766090, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766088, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766089, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766087, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766135, 9789179779733, 'Resan till Interversum', 'http://libris.kb.se/bib/zfg6bf9qwpnwdntn', 'tillgänglig'),
(98766134, 9789179779733, 'Resan till Interversum', 'http://libris.kb.se/bib/zfg6bf9qwpnwdntn', 'tillgänglig'),
(98766133, 9789179779733, 'Resan till Interversum', 'http://libris.kb.se/bib/zfg6bf9qwpnwdntn', 'tillgänglig'),
(98766132, 9153406664, 'Sy kläder av mjuka tyger', 'http://libris.kb.se/bib/7413476', 'tillgänglig'),
(98766131, 9789127150300, 'Vildplockat : ätliga örter, blad, blommor, bär och svampar från den svenska naturen', 'http://libris.kb.se/bib/19769802', 'tillgänglig'),
(98766130, 9789127150300, 'Vildplockat : ätliga örter, blad, blommor, bär och svampar från den svenska naturen', 'http://libris.kb.se/bib/19769802', 'tillgänglig'),
(98766129, 9789127150300, 'Vildplockat : ätliga örter, blad, blommor, bär och svampar från den svenska naturen', 'http://libris.kb.se/bib/19769802', 'tillgänglig'),
(98766128, 9789127150300, 'Vildplockat : ätliga örter, blad, blommor, bär och svampar från den svenska naturen', 'http://libris.kb.se/bib/19769802', 'tillgänglig'),
(98766127, 9789127150300, 'Vildplockat : ätliga örter, blad, blommor, bär och svampar från den svenska naturen', 'http://libris.kb.se/bib/19769802', 'tillgänglig'),
(98766126, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766125, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766124, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766123, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766122, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766121, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766120, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766119, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766118, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766117, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766116, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766115, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766114, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766113, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766112, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766111, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766110, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766109, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766108, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766107, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766106, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766105, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766104, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766103, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766102, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766101, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766100, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766098, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766099, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766097, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766096, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766095, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766094, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766093, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766086, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766085, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766084, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766083, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766082, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766076, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'utlånad'),
(98766075, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766074, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766073, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'utlånad'),
(98766072, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766092, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766070, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766069, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766068, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766067, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'utlånad'),
(98766066, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766081, 9789140693686, 'Viewpoints', 'http://libris.kb.se/bib/t3pck9s7rzqj9mf3', 'tillgänglig'),
(98766064, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766063, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766062, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766061, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766060, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766059, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766058, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766057, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766056, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766055, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766054, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766053, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766052, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766051, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766050, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766049, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766048, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766047, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766046, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766045, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766044, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766043, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766042, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766041, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766040, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766039, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766038, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766037, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766036, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766035, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766034, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766033, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766032, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766031, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766030, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766028, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766029, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765789, 9789127150300, 'Vildplockat : ätliga örter, blad, blommor, bär och svampar från den svenska naturen', 'http://libris.kb.se/bib/19769802', 'tillgänglig'),
(98766027, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766026, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766025, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766024, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766023, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766022, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766021, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766020, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766019, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766018, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766017, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766016, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766015, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766014, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766013, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766012, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766011, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766010, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766009, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766008, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766007, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766006, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766005, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766004, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766003, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766002, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766001, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98766000, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765999, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765998, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765997, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765996, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765995, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765994, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765993, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765992, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765991, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765989, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765990, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765988, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig'),
(98765987, 9789152319895, 'Svenska impulser', 'http://libris.kb.se/bib/14554628', 'tillgänglig');

-- --------------------------------------------------------

--
-- Tabellstruktur `låntagare`
--

DROP TABLE IF EXISTS `låntagare`;
CREATE TABLE IF NOT EXISTS `låntagare` (
  `lånekortsnr_pk` varchar(255) NOT NULL,
  `namn` varchar(255) NOT NULL,
  PRIMARY KEY (`lånekortsnr_pk`)
) ENGINE=MyISAM AUTO_INCREMENT=12345681 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `låntagare`
--

INSERT INTO `låntagare` (`lånekortsnr_pk`, `namn`) VALUES
('F795FA9E', 'Einar Harri'),
('E64D3264', 'Ulf Von Tell'),
('B7EBEC9E', 'Ludvig Ankartoft'),
('2765369F', 'Oscar Eriksson'),
('E4889F3C', 'Anita Harri'),
('57F0CAA2', 'Daniel Andersson');

-- --------------------------------------------------------

--
-- Tabellstruktur `utlån`
--

DROP TABLE IF EXISTS `utlån`;
CREATE TABLE IF NOT EXISTS `utlån` (
  `id_pk` int(255) NOT NULL AUTO_INCREMENT,
  `streckkodsnr_fk` bigint(255) NOT NULL,
  `lånekortsnr_fk` varchar(255) NOT NULL,
  `utlåningsdatum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pk`)
) ENGINE=MyISAM AUTO_INCREMENT=1048 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `utlån`
--

INSERT INTO `utlån` (`id_pk`, `streckkodsnr_fk`, `lånekortsnr_fk`, `utlåningsdatum`) VALUES
(1042, 98766073, 'E4889F3C', '2023-05-23 21:46:36'),
(1044, 98766067, 'F795FA9E', '2023-05-24 14:27:37');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
