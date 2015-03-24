--
-- Base de donn�es: `rosytarte`
--

CREATE DATABASE 'eboutik';
USE 'eboutik'

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `idArticle` int(11) NOT NULL auto_increment,
  `nomArticle` varchar(20) default NULL,
  `imageArticle` varchar(40) default NULL,
  `prixArticle` float default NULL,
  `descriptionArticle` varchar(40) default NULL,
  `idCategorie` int(11) NOT NULL,
  `type` enum('new','old') NOT NULL,
  PRIMARY KEY  (`idArticle`),
  KEY `idCategorie` (`idCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `idCategorie` int(11) NOT NULL auto_increment,
  `nomCategorie` varchar(40) default NULL,
  PRIMARY KEY  (`idCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `pseudo` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `motDePasse` varchar(40) NOT NULL,
  `adresse` varchar(40) NOT NULL,
  `codePostal` int(11) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresseMail` varchar(40) NOT NULL,
  PRIMARY KEY  (`adresseMail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `idCommande` int(11) NOT NULL auto_increment,
  `dateCommande` datetime NOT NULL,
  `idClient` varchar(40) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`idCommande`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure de la table `lignesdecommande`
--

CREATE TABLE `lignesdecommande` (
  `idCommande` int(11) NOT NULL,
  `idArticle` int(11) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`idCommande`,`idArticle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
