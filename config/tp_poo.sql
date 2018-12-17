-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 16 nov. 2018 à 15:55
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tp_blog`
--
CREATE DATABASE IF NOT EXISTS `tp_blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `tp_blog`;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_publication` date NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `titre`, `date_publication`, `contenu`) VALUES
(1, 'Test titre', '2018-11-15', 'Test contenu'),
(2, 'Bienvenue sur le blog', '2018-11-16', 'Un petit blog crÃ©Ã© en PHP'),
(3, 'Hello World', '2018-11-16', '# Titre\r\n\r\n> Cette page devrait traduire le markdown en HTML'),
(4, 'Initiation au MarkDown edit', '2018-11-16', '# Un titre h1 edit\r\n\r\n## Titre h2\r\n\r\nOn peut formatter du texte en **gras**, *italique* ou ***les deux***.\r\n\r\n>Faire des blocs de citation\r\n\r\nEt mÃªme des listes:\r\n\r\n - element de liste 1\r\n - element de liste 2\r\n - element de liste 3\r\n\r\n```\r\n$foo = \'bar\';\r\n```\r\nEncore du code:\r\n\r\n    $bar = \'baz\';\r\n\r\nVoici un tableau:\r\n\r\n| colonne 1 | colonne 2 | colonne 3 |\r\n|---|---|---|\r\n| valeur 1 | valeur 2 | valeur 3 |\r\n| val 1 | val 2 | val 3 |\r\n\r\nLien vers [Github](https://github.com)');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(3) NOT NULL,
  `id_article` int(4) NOT NULL,
  `publication` datetime NOT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `email`, `mdp`, `type`) VALUES
(1, 'admin', 'admin@blog.fr', '$2y$10$JTSE0deQwym3.Z9z06PyjO4JFFCvBtYeIqdwsLC37a0KL9as0wr56', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
