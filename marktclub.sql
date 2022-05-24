
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `marktclub`;

use `marktclub`;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissao` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_criacao` datetime NOT NULL,
  `data_atualizacao` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

TRUNCATE TABLE `usuario`;

INSERT IGNORE INTO `usuario` (`id`, `uuid`, `nome`, `cpf`, `email`, `senha`, `permissao`, `data_criacao`, `data_atualizacao`, `status`) VALUES
(1, 'e90ed746-834e-5596-8adf-e5eef335a94f', 'admin', '725.813.224-46', 'admin@gmail.com', '$2y$10$ZCoSiBwtA1x4DiyXprcnIO7y3bW4LZli7CsRwWnYxgegA5pmDzKIm', '1-2-3-4-', '2022-05-24 08:27:01', '2022-05-24 08:27:01', 1),
(2, 'b9a297e4-e8a3-5599-a575-11659161f33f', 'usuario', '067.520.142-05', 'usuario@gmail.com', '$2y$10$qXmA6Rjhhe5ucobb16DcZuJEx6SYOlwbU66ykFFPWTQUVnZCNJmY2', '1-', '2022-05-24 08:29:29', '2022-05-24 08:29:29', 1);
COMMIT;
