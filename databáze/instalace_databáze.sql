-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Ned 06. lis 2022, 20:31
-- Verze serveru: 5.7.36
-- Verze PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `sp_kiv_web`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `lrunt_pravo`
--

DROP TABLE IF EXISTS `lrunt_pravo`;
CREATE TABLE IF NOT EXISTS `lrunt_pravo` (
  `id_pravo` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `vaha` int(11) NOT NULL,
  PRIMARY KEY (`id_pravo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lrunt_pravo`
--

INSERT INTO `lrunt_pravo` (`id_pravo`, `nazev`, `vaha`) VALUES
(1, 'Super Admin', 20),
(2, 'Admin', 10),
(3, 'Správce', 5),
(4, 'Recenzent', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `lrunt_produkt`
--

DROP TABLE IF EXISTS `lrunt_produkt`;
CREATE TABLE IF NOT EXISTS `lrunt_produkt` (
  `id_produkt` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(11) NOT NULL,
  `mnozstvi` varchar(10) COLLATE utf8_czech_ci NOT NULL,
  `id_typ` int(11) DEFAULT NULL,
  `photo` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_produkt`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lrunt_produkt`
--

INSERT INTO `lrunt_produkt` (`id_produkt`, `nazev`, `cena`, `mnozstvi`, `id_typ`, `photo`) VALUES
(1, 'Smažený sýr, hranolky, tatarská omáčka', 70, '100g', 2, 'data/products/20221023041254lrunt-smazak.jpg'),
(16, 'Palačinka', 50, '100g', 3, 'data/products/20221027121412lrunt-Palatschinke.jpg'),
(17, 'Řízek s bramborovým salátem', 120, '120g', 2, 'data/products/20221105032038admin2-rizek.jpg'),
(18, 'Hovězí svíčková pečeně', 150, '200g', 2, 'data/products/20221105032134admin2-svickova.jpg'),
(19, 'Kozel 11', 32, '0,5l', 4, 'data/products/20221105032858admin2-kozel.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `lrunt_recenze`
--

DROP TABLE IF EXISTS `lrunt_recenze`;
CREATE TABLE IF NOT EXISTS `lrunt_recenze` (
  `id_recenze` int(11) NOT NULL AUTO_INCREMENT,
  `id_uzivatel` int(11) NOT NULL,
  `id_produkt` int(11) DEFAULT NULL,
  `hodnoceni` int(11) NOT NULL,
  `zverejneno` tinyint(1) DEFAULT NULL,
  `datum` timestamp NULL DEFAULT NULL,
  `popis` varchar(1000) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_recenze`),
  KEY `fk_recenze_uzivatel_idx` (`id_uzivatel`),
  KEY `fk_recenze_produkt_idx` (`id_produkt`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lrunt_recenze`
--

INSERT INTO `lrunt_recenze` (`id_recenze`, `id_uzivatel`, `id_produkt`, `hodnoceni`, `zverejneno`, `datum`, `popis`) VALUES
(19, 22, 19, 5, 1, '2022-11-06 18:04:30', 'Bíla pěna, láhev orosená\nchmelový nektar já znám\njen jsem to zkusil a jednou se napil\nod těch dob žízeň mám.'),
(20, 22, 16, 3, 1, '2022-11-06 18:14:28', 'Palačinka byla dobrá. Domácí šlahačka taky potěšila. Raději mám, ale lívance a pitíčko.'),
(21, 22, 1, 4, 1, '2022-11-06 18:15:28', 'Smažák s hranolkami je výbornýýýý!!!!!'),
(22, 21, 17, 5, 0, '2022-11-06 18:29:43', 'U plotny stál,\r\nnevěděl co dál.\r\nPoprvé si řízek,\r\nusmažit chtěl sám.\r\nTeflonová pánev,\r\nskleněné víko,\r\nrozpálený olej,\r\nna šporácích přichystal. \r\nŘízku,\r\nřízku.\r\nJá tě mám moc rád.\r\nŘízku,\r\nřízku.\r\nJá tě udělám.');

-- --------------------------------------------------------

--
-- Struktura tabulky `lrunt_typ_produktu`
--

DROP TABLE IF EXISTS `lrunt_typ_produktu`;
CREATE TABLE IF NOT EXISTS `lrunt_typ_produktu` (
  `id_typ` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_typ`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lrunt_typ_produktu`
--

INSERT INTO `lrunt_typ_produktu` (`id_typ`, `nazev`) VALUES
(1, 'Polévka'),
(2, 'Hlavní jídlo'),
(3, 'Desert'),
(4, 'Nápoj');

-- --------------------------------------------------------

--
-- Struktura tabulky `lrunt_uzivatel`
--

DROP TABLE IF EXISTS `lrunt_uzivatel`;
CREATE TABLE IF NOT EXISTS `lrunt_uzivatel` (
  `id_uzivatel` int(11) NOT NULL AUTO_INCREMENT,
  `id_pravo` int(11) NOT NULL DEFAULT '3',
  `username` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(200) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_uzivatel`),
  KEY `fk_uzivatel_pravo_idx` (`id_pravo`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `lrunt_uzivatel`
--

INSERT INTO `lrunt_uzivatel` (`id_uzivatel`, `id_pravo`, `username`, `heslo`, `email`) VALUES
(4, 1, 'lrunt', '$2y$10$Rj2jOl4pof1MgWVAmX5NwOtMRoejA0iQqfFW4l7BN1VnHX83P3fZK', 'lukas.runt@seznam.cz'),
(20, 2, 'admin', '$2y$10$TDw8yWxODJejQMUm8yp9tO5rgs6wB2vLy7QDpAdzTlnEyRs4E7CQK', 'admin@gmail.com'),
(21, 3, 'spravce', '$2y$10$X2JOpd1QONVCtIiC9qtd5.n8UP1dJA9M/iJrgRl022z.TpnVy9/C2', 'spravce128@seznam.cz'),
(22, 4, 'zvědavá_kachna', '$2y$10$ZXuZiqva8amjXiutgbMCrOnj7hQjhZfz5nFE6rW0Pj1r58OcXLsuS', 'memer666@email.cz');

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `lrunt_recenze`
--
ALTER TABLE `lrunt_recenze`
  ADD CONSTRAINT `fk_recenze_produkt` FOREIGN KEY (`id_produkt`) REFERENCES `lrunt_produkt` (`id_produkt`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recenze_uzivatel` FOREIGN KEY (`id_uzivatel`) REFERENCES `lrunt_uzivatel` (`id_uzivatel`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `lrunt_uzivatel`
--
ALTER TABLE `lrunt_uzivatel`
  ADD CONSTRAINT `fk_uzivatel_pravo` FOREIGN KEY (`id_pravo`) REFERENCES `lrunt_pravo` (`id_pravo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
