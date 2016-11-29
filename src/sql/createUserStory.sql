-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 28 Novembre 2016 à 17:44
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `alaguitard`
--

-- --------------------------------------------------------

--
-- Structure de la table `UserStory`
--

CREATE TABLE IF NOT EXISTS `UserStory` (
  `us_id` int(10) unsigned NOT NULL auto_increment,
  `number_in_project` int(11) NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `effort` int(10) NOT NULL,
  `priority` int(10) NOT NULL,
  `commit` text,
  PRIMARY KEY  (`us_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `UserStory`
--
ALTER TABLE `UserStory`
  ADD CONSTRAINT `UserStory_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `Project` (`project_id`);
