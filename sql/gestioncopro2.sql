-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Janvier 2018 à 16:00
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gestioncopro2`
--

-- --------------------------------------------------------

--
-- Structure de la table `app_charges`
--

DROP TABLE IF EXISTS `app_charges`;
CREATE TABLE IF NOT EXISTS `app_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `montant` double NOT NULL,
  `date_echeance` date NOT NULL,
  `statut` int(11) NOT NULL,
  `piece_jointe` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_contrat` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `app_charges`
--

INSERT INTO `app_charges` (`id`, `titre`, `montant`, `date_echeance`, `statut`, `piece_jointe`, `id_contrat`) VALUES
(17, 'Rénovation portailll', 120, '2019-01-15', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `app_conversation`
--

DROP TABLE IF EXISTS `app_conversation`;
CREATE TABLE IF NOT EXISTS `app_conversation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `projet_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_48003C68C18272` (`projet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `app_conversation`
--

INSERT INTO `app_conversation` (`id`, `name`, `projet_id`) VALUES
(14, 'Conversation Projet Projet 2', NULL),
(15, 'Conversation globale', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `app_message`
--

DROP TABLE IF EXISTS `app_message`;
CREATE TABLE IF NOT EXISTS `app_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_conversation` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `app_message`
--

INSERT INTO `app_message` (`id`, `date`, `message`, `id_user`, `id_conversation`) VALUES
(1, '2018-01-12 08:37:06', 'Bonjour à Tous', 3, 5),
(2, '2018-01-12 08:37:48', 'Salut Ludo', 2, 5),
(3, '2018-01-12 09:02:44', 'Test premier message', 2, 6),
(4, '2018-01-12 15:40:03', '1 er message de la conversation', 2, 15);

-- --------------------------------------------------------

--
-- Structure de la table `app_reunion`
--

DROP TABLE IF EXISTS `app_reunion`;
CREATE TABLE IF NOT EXISTS `app_reunion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lieu` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `organisateur` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `compteRendu` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `app_reunion`
--

INSERT INTO `app_reunion` (`id`, `date`, `name`, `lieu`, `organisateur`, `compteRendu`) VALUES
(6, '2017-06-03 14:15:00', 'Nom', 'Chez moi', 'lucas', '6255c004c062e728a39f030cc37b70cf.pdf'),
(7, '2017-06-03 14:15:00', 'Test réunion', 'Chez Jojo', 'lucas', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
CREATE TABLE IF NOT EXISTS `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C2502824F85E0677` (`username`),
  UNIQUE KEY `UNIQ_C2502824E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `password`, `email`, `is_active`, `roles`) VALUES
(1, 'jojo', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'jojo.com', 1, 'a:1:{i:0;s:9:"ROLE_USER";}'),
(2, 'lucas', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'lucas.com', 1, 'a:2:{i:0;s:9:"ROLE_USER";i:1;s:10:"ROLE_ADMIN";}'),
(3, 'ludo', '$2a$08$jHZj/wJfcVKlIwr5AvR78euJxYK7Ku5kURNhNx.7.CSIJ3Pq6LEPC', 'ludo.com', 1, 'a:1:{i:0;s:9:"ROLE_USER";}');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

DROP TABLE IF EXISTS `projet`;
CREATE TABLE IF NOT EXISTS `projet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proprietaire_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `statut` enum('En discussion','En attente d execution','Execute') COLLATE utf8_unicode_ci DEFAULT NULL,
  `dateOuverture` date NOT NULL,
  `dateCloture` date DEFAULT NULL,
  `piece_jointe` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discussion_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_50159CA91ADED311` (`discussion_id`),
  KEY `IDX_50159CA976C50E4A` (`proprietaire_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`id`, `proprietaire_id`, `nom`, `description`, `statut`, `dateOuverture`, `dateCloture`, `piece_jointe`, `discussion_id`) VALUES
(8, NULL, 'Nom du projet', 'Projet sans discussion', 'En attente d execution', '2016-01-07', '2023-03-08', NULL, NULL),
(9, NULL, 'Projet 2', 'Projet avec conversation', 'En discussion', '2015-02-03', '2016-04-04', NULL, 14);

-- --------------------------------------------------------

--
-- Structure de la table `reponse_sondage`
--

DROP TABLE IF EXISTS `reponse_sondage`;
CREATE TABLE IF NOT EXISTS `reponse_sondage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_sondage_id` int(11) DEFAULT NULL,
  `reponse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FC7EB7A61F7E2E81` (`id_sondage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sondage`
--

DROP TABLE IF EXISTS `sondage`;
CREATE TABLE IF NOT EXISTS `sondage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_projet_id` int(11) DEFAULT NULL,
  `question` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7579C89F80F43E55` (`id_projet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_charges`
--

DROP TABLE IF EXISTS `user_charges`;
CREATE TABLE IF NOT EXISTS `user_charges` (
  `user_id` int(11) NOT NULL,
  `charges_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`charges_id`),
  KEY `IDX_62E24E10A76ED395` (`user_id`),
  KEY `IDX_62E24E10FDFE4111` (`charges_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user_charges`
--

INSERT INTO `user_charges` (`user_id`, `charges_id`) VALUES
(1, 17),
(2, 17),
(3, 17);

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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_conversation`
--

INSERT INTO `user_conversation` (`id`, `id_user`, `id_conversation`) VALUES
(1, 1, 5),
(2, 2, 5),
(3, 3, 5),
(4, 1, 6),
(5, 2, 6),
(6, 3, 6),
(7, 1, 7),
(8, 2, 7),
(9, 3, 7),
(10, 1, 8),
(11, 2, 8),
(12, 3, 8),
(13, 1, 9),
(14, 2, 9),
(15, 3, 9),
(16, 1, 10),
(17, 2, 10),
(18, 3, 10),
(19, 1, 11),
(20, 2, 11),
(21, 3, 11),
(22, 1, 12),
(23, 2, 12),
(24, 3, 12),
(25, 1, 13),
(26, 2, 13),
(27, 3, 13),
(28, 1, 14),
(29, 2, 14),
(30, 3, 14),
(31, 1, 15),
(32, 2, 15);

-- --------------------------------------------------------

--
-- Structure de la table `versement`
--

DROP TABLE IF EXISTS `versement`;
CREATE TABLE IF NOT EXISTS `versement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proprietaire_id` int(11) DEFAULT NULL,
  `charge_liee_id` int(11) DEFAULT NULL,
  `montant` double NOT NULL,
  `date` date NOT NULL,
  `piece_jointe` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('Cheque','Virement bancaire') COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_716E936776C50E4A` (`proprietaire_id`),
  KEY `IDX_716E93676E40B0F6` (`charge_liee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `versement`
--

INSERT INTO `versement` (`id`, `proprietaire_id`, `charge_liee_id`, `montant`, `date`, `piece_jointe`, `type`) VALUES
(9, 2, 17, 100, '2017-01-01', NULL, 'Virement bancaire');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `app_conversation`
--
ALTER TABLE `app_conversation`
  ADD CONSTRAINT `FK_48003C68C18272` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`);

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `FK_50159CA91ADED311` FOREIGN KEY (`discussion_id`) REFERENCES `app_conversation` (`id`),
  ADD CONSTRAINT `FK_50159CA976C50E4A` FOREIGN KEY (`proprietaire_id`) REFERENCES `app_users` (`id`);

--
-- Contraintes pour la table `reponse_sondage`
--
ALTER TABLE `reponse_sondage`
  ADD CONSTRAINT `FK_FC7EB7A61F7E2E81` FOREIGN KEY (`id_sondage_id`) REFERENCES `sondage` (`id`);

--
-- Contraintes pour la table `sondage`
--
ALTER TABLE `sondage`
  ADD CONSTRAINT `FK_7579C89F80F43E55` FOREIGN KEY (`id_projet_id`) REFERENCES `projet` (`id`);

--
-- Contraintes pour la table `user_charges`
--
ALTER TABLE `user_charges`
  ADD CONSTRAINT `FK_62E24E10A76ED395` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_62E24E10FDFE4111` FOREIGN KEY (`charges_id`) REFERENCES `app_charges` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `versement`
--
ALTER TABLE `versement`
  ADD CONSTRAINT `FK_716E93676E40B0F6` FOREIGN KEY (`charge_liee_id`) REFERENCES `app_charges` (`id`),
  ADD CONSTRAINT `FK_716E936776C50E4A` FOREIGN KEY (`proprietaire_id`) REFERENCES `app_users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
