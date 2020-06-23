-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 23-Jun-2020 às 20:19
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hospital`
--
CREATE DATABASE IF NOT EXISTS `db_hospital` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `db_hospital`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `hospital`
--

DROP TABLE IF EXISTS `hospital`;
CREATE TABLE IF NOT EXISTS `hospital` (
  `id_hospital` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `total_UTI` int(11) NOT NULL,
  `total_enfermaria` int(11) NOT NULL,
  PRIMARY KEY (`id_hospital`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `hospital`
--

INSERT INTO `hospital` (`id_hospital`, `nome`, `email`, `senha`, `total_UTI`, `total_enfermaria`) VALUES
(1, 'Hospital SBC', 'sbcmain@hotmail.com', 'acesso_123', 10, 10),
(2, 'Hospital Central - SP', 'central@hotmail.com', '123', 4, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `leitos`
--

DROP TABLE IF EXISTS `leitos`;
CREATE TABLE IF NOT EXISTS `leitos` (
  `id_leito` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_leito` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `num_leito` int(11) NOT NULL,
  `status_leito` enum('Disponivel','Ocupado') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Disponivel',
  `id_hospital` int(11) NOT NULL,
  PRIMARY KEY (`id_leito`),
  KEY `id_hospital` (`id_hospital`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `leitos`
--

INSERT INTO `leitos` (`id_leito`, `tipo_leito`, `num_leito`, `status_leito`, `id_hospital`) VALUES
(1, 'UTI', 1, 'Disponivel', 1),
(2, 'UTI', 2, 'Disponivel', 1),
(3, 'UTI', 3, 'Disponivel', 1),
(4, 'UTI', 4, 'Disponivel', 1),
(5, 'UTI', 5, 'Disponivel', 1),
(6, 'UTI', 6, 'Disponivel', 1),
(7, 'UTI', 7, 'Disponivel', 1),
(8, 'UTI', 8, 'Disponivel', 1),
(9, 'UTI', 9, 'Disponivel', 1),
(10, 'UTI', 10, 'Disponivel', 1),
(11, 'Enfermaria', 1, 'Disponivel', 1),
(12, 'Enfermaria', 2, 'Disponivel', 1),
(13, 'Enfermaria', 3, 'Disponivel', 1),
(14, 'Enfermaria', 4, 'Disponivel', 1),
(15, 'Enfermaria', 5, 'Disponivel', 1),
(16, 'Enfermaria', 6, 'Disponivel', 1),
(17, 'Enfermaria', 7, 'Disponivel', 1),
(18, 'Enfermaria', 8, 'Disponivel', 1),
(19, 'Enfermaria', 9, 'Disponivel', 1),
(20, 'Enfermaria', 10, 'Disponivel', 1),
(21, 'UTI', 1, 'Disponivel', 2),
(22, 'UTI', 2, 'Disponivel', 2),
(23, 'UTI', 3, 'Disponivel', 2),
(24, 'UTI', 4, 'Disponivel', 2),
(25, 'Enfermaria', 1, 'Disponivel', 2),
(26, 'Enfermaria', 2, 'Disponivel', 2),
(27, 'Enfermaria', 3, 'Disponivel', 2),
(28, 'Enfermaria', 4, 'Disponivel', 2),
(29, 'Enfermaria', 5, 'Disponivel', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id_paciente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cpf` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nascimento` date NOT NULL,
  `hora_entrada` time NOT NULL,
  `data_entrada` date NOT NULL,
  `id_leito` int(11) NOT NULL,
  `id_hospital` int(11) NOT NULL,
  PRIMARY KEY (`id_paciente`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `id_leito` (`id_leito`),
  KEY `id_hospital` (`id_hospital`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `leitos`
--
ALTER TABLE `leitos`
  ADD CONSTRAINT `leitos_ibfk_1` FOREIGN KEY (`id_hospital`) REFERENCES `hospital` (`id_hospital`);

--
-- Limitadores para a tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`id_leito`) REFERENCES `leitos` (`id_leito`),
  ADD CONSTRAINT `pacientes_ibfk_2` FOREIGN KEY (`id_hospital`) REFERENCES `hospital` (`id_hospital`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
