-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 28 Novembre 2016 à 17:34
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `alaguitard`
--

-- --------------------------------------------------------

--
-- Structure de la table `Sprint`
--

CREATE TABLE IF NOT EXISTS `Sprint` (
  `sprint_id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL,
  `number_sprint` int(11) NOT NULL,
  `date_start` date NOT NULL,
  PRIMARY KEY  (`sprint_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Sprint`
--
ALTER TABLE `Sprint`
  ADD CONSTRAINT `Sprint_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `Project` (`project_id`);
