-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Creation date: May 17h 2016 at 20:48
-- SErver version: 5.1.73-1+deb6u1
-- PHP Version: 5.4.38

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- database: `myvoc`
--

-- --------------------------------------------------------

--
-- table structure `myVocCategory`
--

CREATE TABLE IF NOT EXISTS `myVocCategory` (
  `CategoryID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(50) NOT NULL,
  `LanguageIDBase` smallint(5) unsigned NOT NULL,
  `LanguageIDTranslation` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `UK1_Category` (`CategoryName`,`LanguageIDBase`,`LanguageIDTranslation`),
  KEY `FK_Category_Language_Base` (`LanguageIDBase`),
  KEY `FK_Category_Language_Translation` (`LanguageIDTranslation`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- table structure `myVocLanguage`
--

CREATE TABLE IF NOT EXISTS `myVocLanguage` (
  `LanguageID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `LanguageName` varchar(25) NOT NULL,
  PRIMARY KEY (`LanguageID`),
  UNIQUE KEY `UK1_Language` (`LanguageName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- table structure `myVocWord`
--

CREATE TABLE IF NOT EXISTS `myVocWord` (
  `WordID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `WordBase` varchar(200) NOT NULL,
  `WordTranslation` varchar(200) NOT NULL,
  `CategoryID` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`WordID`),
  UNIQUE KEY `UK1_Word` (`WordBase`,`WordTranslation`),
  KEY `FK_Word_Category` (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7430 ;

--
-- constraints
--

--
-- Constraints for table `myVocCategory`
--
ALTER TABLE `myVocCategory`
  ADD CONSTRAINT `FK_Categpry_Language_Base` FOREIGN KEY (`LanguageIDBase`) REFERENCES `myVocLanguage` (`LanguageID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Categpry_Language_Translation` FOREIGN KEY (`LanguageIDTranslation`) REFERENCES `myVocLanguage` (`LanguageID`) ON UPDATE CASCADE;

--
-- Constraints for table `myVocWord`
--
ALTER TABLE `myVocWord`
  ADD CONSTRAINT `FK_Word_Category` FOREIGN KEY (`CategoryID`) REFERENCES `myVocCategory` (`CategoryID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
