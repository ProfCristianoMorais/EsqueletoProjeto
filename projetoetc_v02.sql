-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27-Mar-2025 às 00:28
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetoetc_v02`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `endereco` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `data_cadastro`, `endereco`) VALUES
(1, 'Cristiano Morais', 'cristiano@cristiano.com', '61982281599', '2025-03-25 14:05:56', 'UnB'),
(6, 'Teste', 'teste@teste.com', '615555', '2025-03-26 22:55:02', 'Bem Ali'),
(7, 'Fulano de tal', 'fulano@fulano.com', '', '2025-03-26 22:55:10', 'Bem ali');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `estoque` int(11) DEFAULT 0,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `estoque`, `data_cadastro`) VALUES
(1, 'Televisão LG', 'Televisão 65 polegadas', '3500.00', 4, '2025-03-25 16:08:34'),
(2, 'PS5', 'Playstation 5 slim', '2800.00', 3, '2025-03-25 16:13:18'),
(3, 'nitendo', 'bom ou ruim ou sei lá', '1200.00', 3, '2025-03-25 23:32:36'),
(5, 'Máquina de lavar', 'Brastemp', '1800.00', 5, '2025-03-26 22:57:54');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','vendedor','cliente') DEFAULT 'cliente',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `data_cadastro`) VALUES
(5, 'Cristiano Morais', 'cristiano@cristiano.com', '$2y$10$b.AKoOugRPJHYDIJAno8euuD53JkPk4SmpBxX.5ZfG5g98B3sWocK', 'admin', '2025-03-25 17:51:39'),
(6, 'Micaela Miranda de Morais', 'micaela@micaela.com', '$2y$10$Ht2qBgRRs5HC2MsdjzRvbeNSpVDtBuLVGrBsnS/L27UCS/5SL34jC', 'admin', '2025-03-25 18:31:59'),
(7, 'Aline Morais', 'aline@aline.com', '$2y$10$ZNcjaWlJ.NVtLVF.gOi7duWF.GjV62yA7IA378iAGytyANyBGL.4G', 'vendedor', '2025-03-25 18:36:04'),
(8, 'Bia', 'bia@bia.com', '$2y$10$LXd8WvlRg2gqXtJtohNOR.HbheC9K2G8UagFjMKpUX.sBuu2li/c.', 'cliente', '2025-03-26 23:25:13');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
