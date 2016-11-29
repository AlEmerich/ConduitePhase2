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
-- Structure de la table `RelationSprintsUS`
--

CREATE TABLE IF NOT EXISTS `RelationSprintsUS` (
  `sprint_id` int(10) unsigned NOT NULL,
  `us_id` int(10) unsigned NOT NULL,
  `finished` tinyint(1) NOT NULL,
  KEY `sprint_id` (`sprint_id`),
  KEY `us_id` (`us_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `RelationSprintsUS`
--
ALTER TABLE `RelationSprintsUS`
  ADD CONSTRAINT `RelationSprintsUS_ibfk_1` FOREIGN KEY (`sprint_id`) REFERENCES `Sprint` (`sprint_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RelationSprintUS_ibfk_3` FOREIGN KEY (`us_id`) REFERENCES `UserStory` (`us_id`) ON DELETE CASCADE ON UPDATE CASCADE;
