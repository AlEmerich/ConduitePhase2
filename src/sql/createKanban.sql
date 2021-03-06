-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 30 Novembre 2016 à 21:58
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
  `k_id` int(10) unsigned NOT NULL auto_increment,
  `task_id` int(10) unsigned NOT NULL,
  `state` smallint(6) NOT NULL,
  `dev_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`k_id`),
  KEY `task_id` (`task_id`),
  KEY `dev_id` (`dev_id`)
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
  ADD CONSTRAINT `Kanban_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `Task` (`task_id`);
