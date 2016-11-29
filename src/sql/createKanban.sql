-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 28 Novembre 2016 à 17:31
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `alaguitard`
--

-- --------------------------------------------------------

--
-- Structure de la table `Kanban`
--

CREATE TABLE IF NOT EXISTS `Kanban` (
  `sprint_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `state` smallint(6) NOT NULL,
  `dev` int(10) unsigned NOT NULL,
  KEY `sprint_id` (`sprint_id`),
  KEY `task_id` (`task_id`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Kanban`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Kanban`
--
ALTER TABLE `Kanban`
  ADD CONSTRAINT `Kanban_ibfk_1` FOREIGN KEY (`sprint_id`) REFERENCES `Sprint` (`sprint_id`),
  ADD CONSTRAINT `Kanban_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `Task` (`task_id`);
