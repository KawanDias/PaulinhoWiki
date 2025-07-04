-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/07/2025 às 14:51
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `paulinhowiki`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `conteudo` text NOT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp(),
  `autor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `conteudo`, `data_publicacao`, `autor_id`) VALUES
(3, '[NOVIDADE] A página de notícias está funcionando!', 'Uhuu está funcionando!', '2025-07-03 08:16:24', 16),
(4, 'Adicionando nova noticia', 'Essa é a segunda noticia!', '2025-07-03 08:18:48', 16),
(5, 'Atualização Biomes O Plenty', 'Acabou de ser lançada uma nova atualização para a versão 1.21, do biomes o plenty!', '2025-07-03 08:23:18', 16),
(6, 'adicionando a quarta noticia', 'esse é o conteúdo da noticia', '2025-07-03 08:24:58', 16),
(7, 'noticia numero cin', 'este é o conteudo da noticia1234teste', '2025-07-03 09:25:29', 17);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tutoriais`
--

CREATE TABLE `tutoriais` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `conteudo` text NOT NULL,
  `data_publicacao` datetime DEFAULT current_timestamp(),
  `autor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tutoriais`
--

INSERT INTO `tutoriais` (`id`, `titulo`, `descricao`, `conteudo`, `data_publicacao`, `autor_id`) VALUES
(1, 'Aprenda a Minerar', 'Gostaria de aprender a minerar, esse é o passo a passo completo para você!', 'Minerar é uma das atividades mais importantes do Minecraft, essencial para conseguir recursos como ferro, carvão, ouro, redstone, diamante e muito mais. Abaixo, veja como fazer isso de forma eficiente e segura:', '2025-07-03 08:11:45', 16),
(3, '[tesste] A página de tutoriais está funcionando!', 'teste de descrição 123', 'lorem rene ipsum', '2025-07-03 09:25:40', 16),
(4, '[NOVIDADE] Acabou de ser lançado o tutorial para Orespawn!', 'Uau, orespawn é bãum!', 'Aqui está o conteúdo sobre orespawn!', '2025-07-03 09:14:22', 16);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `emailUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(100) NOT NULL,
  `datanascUsuario` date NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `tipoUsuario` varchar(5) NOT NULL,
  `fotoUsuario` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `emailUsuario`, `senhaUsuario`, `datanascUsuario`, `nomeUsuario`, `tipoUsuario`, `fotoUsuario`) VALUES
(1, 'leoncio@gmail.com', '$2y$10$qnHzqnuU.uxNzbuBRfWTiOZQzhqAZyLBL9KPL0bLgjPqi/uxu9DHK', '2004-01-15', 'Carlos Magno', 'Aluno', 'uploads/profile_pictures/6863237b552c5.png'),
(2, 'leonc2i2o@gmail.com', '$2y$10$.klz9WQMlnqamY4Pi1xNl.OTlkEiBXnZZDRncJz92b7kAkjZRw0S.', '2005-12-12', 'Carlos Magnosdsa', 'Admin', 'uploads/profile_pictures/686327ba938e5.png'),
(3, 'leo232nc2io@gmail.com', '$2y$10$iJQHvghrbfxcQmMrqPr4megIhujE/qVBl.MlGb9fVGt2/MAULVpRm', '2004-12-15', 'Carlos Magnosdsda', 'Aluno', 'uploads/profile_pictures/68632be90f3cb.png'),
(4, 'kawzin@gmail.com', '$2y$10$9TQGN20.Zu2hi74bNNLEEeBwIQKdTF.MPDx9L2aBocACz/iAdzdKi', '2004-07-15', 'Kawzin', 'Aluno', 'uploads/profile_pictures/6863ecaf53e40.jpg'),
(5, 'kawzin@gmail.com', '$2y$10$JkgJJpIrxvdoUfnYNNiIheiYcCd/BDwqRZlRNMmDx11RMqbmebN9O', '2001-12-12', 'Kawzind', 'Admin', 'uploads/profile_pictures/6863ed4edf601.png'),
(6, 'kawzin@gmail.com', '$2y$10$VXTk/FuN10CrkGZ/2lpadu3LfPQW0OlkGeKcIIuyAQxEN1Yd1KgEe', '2001-12-12', 'Kawzind', 'Admin', 'uploads/profile_pictures/6863eeb168a02.png'),
(7, 'kawz2in@gmail.com', '$2y$10$N4y3appBneygTyHNMBLyd.meQO07r0jqr7MxGaUTWtgafYJKN.njW', '2001-12-12', 'Kawzinds', 'Aluno', 'uploads/profile_pictures/6863f0cba04c8.png'),
(8, 'teste@gmail.com', '$2y$10$dGv5TRHEvFc3Kjp81n9mVe8d2MH8IxsttjTtNoRWwObhG6haIx0Ii', '2001-12-12', 'testedasilva', 'Admin', 'uploads/profile_pictures/6863f42e1060d.jpg'),
(9, 'kaw@gmail.com', '$2y$10$Y6UJdelVtqLBwK1x22/Y2OCxg67cQ.9c1y8enzH.im09d4q3fAjUK', '2001-12-12', 'testedois', 'Aluno', 'uploads/profile_pictures/6863f5214ef77.png'),
(10, 'testedodia@gmail.com', '$2y$10$mv/TcZMLY.NVf1Gd1GxKMuglYwtYI/gc19A/8cVdNDNtpKE0s0u92', '2001-12-12', 'testedodia', 'Admin', 'uploads/profile_pictures/68654c90802e8.jpg'),
(11, 'kawandiaskdc@gmail.com', '$2y$10$HBsQKhhFKSwwzaK5wgNNvexMNz3mEzvC8T4hJdkJZ58xb6vc52MFe', '2004-07-15', 'KawKaw12', 'Aluno', 'uploads/profile_pictures/686550866c801.png'),
(12, 'kawand2iaskdc@gmail.com', '$2y$10$0fDI0zneagSIDSiQfVnhc.GhoRGbXqNVSfnR8HV/nWojK5Mb1QTsK', '2005-12-12', 'KawKaw13', 'Aluno', 'uploads/profile_pictures/686550e651714.png'),
(13, 'testetres@gmail.com', '$2y$10$nKl5opDQgxZgz0RmGM1ftuBecF6uJ6fenmcaI3Z.1NWCD7xtimkJ2', '2001-12-12', 'ReneGames', 'Aluno', 'uploads/profile_pictures/686551bc7fb64.jpg'),
(14, 'ka11wzin@gmail.com', '$2y$10$UEiOMIhbZUSUD0i50Dqtv.OOP/J3c9P3p.oUtn1I2XsEHZO9Ne.cK', '2009-12-12', 'NovoTeste', 'Admin', 'uploads/profile_pictures/68665b7b7c799.png'),
(15, 'kawz232in@gmail.com', '$2y$10$RudcO26nNK/amVEJvNfHoORsqD5z7t.5hHkhKMZ/BwGEaPStsWkqu', '2001-12-12', 'NaosouTutor', 'Aluno', 'uploads/profile_pictures/686662f642320.jpg'),
(16, 'ka12312wzin@gmail.com', '$2y$10$fv3/kFQjAkJa3IJuKrwQ5upBpkTtS9LbbsuFH5hDWEW.dtxpYDmA2', '2001-12-12', 'testedois23', 'Admin', 'uploads/profile_pictures/6866632a889c8.jpg'),
(17, 'testequatro@gmail.com', '$2y$10$LdcIn5Xq9nIBJNB2lkKbB.79WYKjuwlx0R3225HqD6RqKwBri1WgC', '2001-12-12', 'TesteQuatro', 'Admin', 'uploads/profile_pictures/686669933f1bb.jpg'),
(18, 'adm@gmail.com', '$2y$10$fl5sF.gytZJoROlhsuhTEOnKm9ZhnrtmcFAdI6vgfFKUnscsUGML6', '2004-12-12', 'admdosite', 'Admin', 'uploads/profile_pictures/6866740d856db.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Índices de tabela `tutoriais`
--
ALTER TABLE `tutoriais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tutoriais`
--
ALTER TABLE `tutoriais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`idUsuario`);

--
-- Restrições para tabelas `tutoriais`
--
ALTER TABLE `tutoriais`
  ADD CONSTRAINT `tutoriais_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`idUsuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
