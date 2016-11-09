-- phpMyAdmin SQL Dump
-- version 3.1.2deb1ubuntu0.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 31 Octobre 2016 à 02:00
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
  `state` TEXT NOT NULL,
  `date_start` TIME NOT NULL,
  `date_stop` TIME NOT NULL,
  PRIMARY KEY  (`sprint_id`),
	FOREIGN KEY(project_id) REFERENCES Project(project_id)
) ENGINE=INNODB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `Sprint`
--
