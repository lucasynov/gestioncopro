-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 20 Décembre 2017 à 19:39
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gestioncopro`
--

-- --------------------------------------------------------

--
-- Structure de la table `app_charges`
--

DROP TABLE IF EXISTS `app_charges`;
CREATE TABLE IF NOT EXISTS `app_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `montant` float NOT NULL,
  `date_echeance` date NOT NULL,
  `statut` int(11) NOT NULL,
  `copropritaires` varchar(100) NOT NULL,
  `piece_jointe` varchar(100) DEFAULT NULL,
  `id_contrat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `app_charges`
--

INSERT INTO `app_charges` (`id`, `titre`, `montant`, `date_echeance`, `statut`, `copropritaires`, `piece_jointe`, `id_contrat`) VALUES
(1, 'Ascenceur', 250, '2018-01-01', 1, 'Tous', '', 1),
(6, 'Elec', 150, '2016-03-08', 0, 'Tous', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `app_conversation`
--

DROP TABLE IF EXISTS `app_conversation`;
CREATE TABLE IF NOT EXISTS `app_conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `app_conversation`
--

INSERT INTO `app_conversation` (`id`, `name`) VALUES
(1, 'Conversation globale'),
(17, 'New convers');

-- --------------------------------------------------------

--
-- Structure de la table `app_message`
--

DROP TABLE IF EXISTS `app_message`;
CREATE TABLE IF NOT EXISTS `app_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `app_message`
--

INSERT INTO `app_message` (`id`, `message`, `date`, `id_user`, `id_conversation`) VALUES
(1, 'Qui a une perceuse ? ', '2017-12-05 08:21:20', 1, 1),
(9, 'Oui passe chez moi quand tu veux !!', '2017-12-07 13:33:06', 2, 1),
(8, 'Est ce que tu pourrai me la préter pour samedi ? Stp', '2017-12-07 13:28:57', 1, 1),
(7, 'Moi j''en ai une si tu veux !! :)', '2017-12-07 13:27:46', 2, 1),
(10, 'Ok', '2017-12-08 10:45:21', 1, 1),
(11, 'Ceci est une nouvelle conversation', '2017-12-08 12:55:50', 1, 17),
(12, 'Ok c''est noté !', '2017-12-08 12:58:32', 2, 17);

-- --------------------------------------------------------

--
-- Structure de la table `app_reunion`
--

DROP TABLE IF EXISTS `app_reunion`;
CREATE TABLE IF NOT EXISTS `app_reunion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `organisateur` varchar(100) NOT NULL,
  `compte_rendu` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `app_reunion`
--

INSERT INTO `app_reunion` (`id`, `date`, `name`, `organisateur`, `compte_rendu`) VALUES
(1, '2017-12-06 14:15:00', 'Réunion de fin d''année', 'lucas', NULL),
(2, '2017-12-06 14:15:00', 'Nouvelle réu', 'jojo', NULL),
(18, '2018-01-05 14:15:00', 'Réunion de début d''année 2018', 'lucas', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
CREATE TABLE IF NOT EXISTS `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(60) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `roles` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `password`, `email`, `is_active`, `roles`) VALUES
(1, 'jojo', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'jojo.com', 1, 'a:1:{i:0;s:9:"ROLE_USER";}'),
(2, 'lucas', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'lucas.com', 1, 'a:2:{i:0;s:9:"ROLE_USER";i:1;s:10:"ROLE_ADMIN";}'),
(3, 'ludo', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'ludo.com', 1, 'a:1:{i:0;s:9:"ROLE_USER";}');

-- --------------------------------------------------------

--
-- Structure de la table `user_conversation`
--

DROP TABLE IF EXISTS `user_conversation`;
CREATE TABLE IF NOT EXISTS `user_conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_conversation`
--

INSERT INTO `user_conversation` (`id`, `id_user`, `id_conversation`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(97, 3, 17),
(96, 2, 17),
(95, 1, 17);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
