/*************************************************/
/* Gestion des posts (BD MySQL) du cours M2203
//
// Création du script de BDD MMIBLOG22
//
// @Martine Bornerie    Le 18/01/22 22:17:00
*/
/*************************************************/

-- First we create the database

CREATE DATABASE `MMIBLOG22`
DEFAULT CHARACTER SET UTF8    -- Tous les formats de caractères
DEFAULT COLLATE utf8_general_ci ; -- 

-- SHOW VARIABLES;        -- Voir les paramètres de la BD

-- Then we add a user to the database

GRANT ALL PRIVILEGES ON `MMIBLOG22`.* TO 'mmiblog_user'@'%' IDENTIFIED BY 'mmiblog_password';;
GRANT ALL PRIVILEGES ON `MMIBLOG22`.* TO 'mmiblog_user'@'LOCALHOST' IDENTIFIED BY 'mmiblog_password';;


-- Flush / Init all privileges
FLUSH PRIVILEGES;

-- Now we create the Database

-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mer 19 Janvier 2022 à 21:57
-- Version du serveur :  5.5.42
-- Version de PHP :  7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  MMIBLOG22
--
USE MMIBLOG22;

-- --------------------------------------------------------

--
-- Structure de la table POST
--

CREATE TABLE POST (
  numPost smallint(6) unsigned NOT NULL,         -- PK
  libPost varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  descripPost text COLLATE utf8_unicode_ci NOT NULL,
  resumPost text COLLATE utf8_unicode_ci NOT NULL,
  statutPost varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  madatPost timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  positPost int(10) unsigned NOT NULL,
  eMailUser varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Structure de la table TAG
--

CREATE TABLE TAG (
  numTag smallint(6) unsigned NOT NULL,      -- PK
  libTag varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  dtCreaTag date NOT NULL,
  dtModifTag date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Structure de la table USER
--

CREATE TABLE USER (
  eMailUser varchar(50) COLLATE utf8_unicode_ci NOT NULL,  -- PK
  loginUser varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  passUser varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  nomUser varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  prenomUser varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  cdDroitUser char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Structure de la table LIKEPOST
--

CREATE TABLE LIKEPOST (
  eMailUser varchar(50) COLLATE utf8_unicode_ci NOT NULL, -- PK, FK
  numPost   smallint(6) unsigned NOT NULL,                -- PK, FK
  likePost  bool
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
--
-- Structure de la table REGROUPEMENT
--

CREATE TABLE REGROUPEMENT (
  numPost smallint(6) unsigned NOT NULL,     -- PK
  numTag  smallint(6) unsigned NOT NULL,
  dtCreaRegroup   date NOT NULL,
  dtModifRegroup  date DEFAULT NULL,
  positRegroup    int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- Index pour les tables exportées
--

--
-- Index pour la table POST
--

ALTER TABLE POST
  ADD PRIMARY KEY (numPost),
  ADD KEY `POST_FK` (numPost),
  ADD KEY `FK_ASSOCIATION_1` (eMailUser);

--
-- Index pour la table REGROUPEMENT
--
ALTER TABLE REGROUPEMENT
  ADD PRIMARY KEY (numPost,numTag),
  ADD KEY `REGROUPEMENT_FK` (numPost,numTag),
  ADD KEY `FK_ASSOCIATION_3` (numTag);

--
-- Index pour la table TAG
--
ALTER TABLE TAG
  ADD PRIMARY KEY (numTag),
  ADD KEY `TAG_FK` (numTag);

--
-- Index pour la table USER
--
ALTER TABLE USER
  ADD PRIMARY KEY (eMailUser),
  ADD KEY `USER_FK` (eMailUser);

--
-- Index pour la table LIKEPOST
--
ALTER TABLE LIKEPOST
  ADD PRIMARY KEY (eMailUser, numPost),
  ADD KEY `LIKEPOST_FK` (eMailUser, numPost);

-- --------------------------------------------------------
-- --------------------------------------------------------
--
-- AUTO_INCREMENT pour les tables exportées
--
-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- AUTO_INCREMENT pour la table POST
--
ALTER TABLE POST
  MODIFY numPost smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT pour la table TAG
--
ALTER TABLE TAG
  MODIFY numTag smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table POST
--
ALTER TABLE POST
  ADD CONSTRAINT `FK_ASSOCIATION_1` FOREIGN KEY (eMailUser) REFERENCES USER (eMailUser);

--
-- Contraintes pour la table REGROUPEMENT
--
ALTER TABLE REGROUPEMENT
  ADD CONSTRAINT `FK_ASSOCIATION_2` FOREIGN KEY (numPost) REFERENCES POST (numPost),
  ADD CONSTRAINT `FK_ASSOCIATION_3` FOREIGN KEY (numTag) REFERENCES TAG (numTag);

--
-- Contraintes pour la table LIKEPOST
--
ALTER TABLE LIKEPOST
  ADD CONSTRAINT `FK_ASSOCIATION_4` FOREIGN KEY (eMailUser) REFERENCES USER (eMailUser),
  ADD CONSTRAINT `FK_ASSOCIATION_5` FOREIGN KEY (numPost) REFERENCES POST (numPost);

-- --------------------------------------------------------
-- --------------------------------------------------------
