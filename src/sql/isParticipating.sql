-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 28 Novembre 2016 à 17:37
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `alaguitard`
--

-- --------------------------------------------------------

--
-- Structure de la table `Participates`
--

CREATE TABLE IF NOT EXISTS `Participates` (
  `project_id` int(10) unsigned NOT NULL,
  `dev_id` int(10) unsigned NOT NULL,
  KEY `project_id` (`project_id`),
  KEY `dev_id` (`dev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Participates`
--
ALTER TABLE `Participates`
  ADD CONSTRAINT `Participates_ibfk_3` FOREIGN KEY (`project_id`) REFERENCES `Project` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Participates_ibfk_4` FOREIGN KEY (`dev_id`) REFERENCES `User` (`dev_id`);
