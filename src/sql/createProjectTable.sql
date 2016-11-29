-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 28 Novembre 2016 à 17:32
-- Version du serveur: 5.0.75
-- Version de PHP: 5.2.6-3ubuntu4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `alaguitard`
--

-- --------------------------------------------------------

--
-- Structure de la table `Project`
--

CREATE TABLE IF NOT EXISTS `Project` (
  `project_id` int(10) unsigned NOT NULL auto_increment,
  `project_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `sprint_duration` int(11) NOT NULL default '7' COMMENT 'En jours',
  `link_repository` text NOT NULL,
  `product_owner` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`project_id`),
  KEY `product_owner` (`product_owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `Project`
--

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Project`
--
ALTER TABLE `Project`
  ADD CONSTRAINT `Project_ibfk_1` FOREIGN KEY (`product_owner`) REFERENCES `User` (`dev_id`);
