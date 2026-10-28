-- =============================================================================
-- Schema e Dados Iniciais (Seed) — Sistema Web Restaurante
-- Banco de Dados: restaurante-bd
-- =============================================================================

CREATE DATABASE IF NOT EXISTS `restaurante-bd`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `restaurante-bd`;

-- -----------------------------------------------------------------------------
-- 1. Tabela: usuario
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `situacao` VARCHAR(20) NOT NULL DEFAULT 'Habilitado',
  `data_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2. Tabela: produto
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `produto` (
  `codigo` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(120) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `valor` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `foto` VARCHAR(255) DEFAULT NULL,
  `info_adicional` TEXT DEFAULT NULL,
  `codigo_usuario` INT DEFAULT NULL,
  `situacao` VARCHAR(20) NOT NULL DEFAULT 'HABILITADO',
  `data_hora` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_produto_usuario`
    FOREIGN KEY (`codigo_usuario`) REFERENCES `usuario` (`codigo`)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 3. Tabela: item_pedido
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `item_pedido` (
  `codigo` INT AUTO_INCREMENT PRIMARY KEY,
  `cod_usuario` INT NOT NULL,
  `nome_produto` VARCHAR(120) NOT NULL,
  `observacao` VARCHAR(255) DEFAULT NULL,
  `preco_und` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `quantidade` INT NOT NULL DEFAULT 1,
  `data_hora` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_item_pedido_usuario`
    FOREIGN KEY (`cod_usuario`) REFERENCES `usuario` (`codigo`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. Seed Inicial — Usuários de Teste
-- Senha de todos os usuários: 123456 (hash MD5: e10adc3949ba59abbe56e057f20f883e)
-- -----------------------------------------------------------------------------
INSERT INTO `usuario` (`codigo`, `nome`, `email`, `senha`, `situacao`) VALUES
  (1, 'Administrador Restaurante', 'admin@restaurante.com', MD5('123456'), 'Habilitado'),
  (2, 'Atendente Caixa', 'atendente@restaurante.com', MD5('123456'), 'Habilitado')
ON DUPLICATE KEY UPDATE
  `nome` = VALUES(`nome`),
  `senha` = VALUES(`senha`),
  `situacao` = VALUES(`situacao`);

-- -----------------------------------------------------------------------------
-- 5. Seed Inicial — Produtos Cadastrados
-- -----------------------------------------------------------------------------
INSERT INTO `produto` (`codigo`, `nome`, `categoria`, `valor`, `foto`, `info_adicional`, `codigo_usuario`, `situacao`) VALUES
  (1, 'Pizza Calabresa Artesanal', 'Pizzas', 49.90, 'pizza-calabresa.jpg', 'Molho de tomate pelati, mussarela, calabresa fatiada, cebola roxa e orégano (8 fatias).', 1, 'HABILITADO'),
  (2, 'Pizza Margherita Especial', 'Pizzas', 46.00, 'pizza-margherita.jpg', 'Mussarela de búfala, rodelas de tomate fresco, manjericão orgânico e azeite extra virgem.', 1, 'HABILITADO'),
  (3, 'Pizza Quatro Queijos', 'Pizzas', 54.90, 'pizza-4-queijos.jpg', 'Mussarela, provolone, parmesão capa preta e catupiry original.', 1, 'HABILITADO'),
  (4, 'Lasanha à Bolonhesa', 'Massas', 38.50, 'lasanha-bolonhesa.jpg', 'Massa fresca artesanal ao ragu de carne bovina, molho bechamel e gratinado de queijo.', 1, 'HABILITADO'),
  (5, 'Refrigerante Lata 350ml', 'Bebidas', 6.50, 'refrigerante-lata.jpg', 'Lata 350ml gelada (Coca-Cola, Guaraná Antarctica ou Sprite).', 2, 'HABILITADO'),
  (6, 'Suco Natural de Laranja 500ml', 'Bebidas', 12.00, 'suco-laranja.jpg', 'Suco 100% natural espremido na hora, sem adição de conservantes.', 2, 'HABILITADO')
ON DUPLICATE KEY UPDATE
  `nome` = VALUES(`nome`),
  `categoria` = VALUES(`categoria`),
  `valor` = VALUES(`valor`),
  `situacao` = VALUES(`situacao`);

-- -----------------------------------------------------------------------------
-- 6. Seed Inicial — Itens de Pedido
-- -----------------------------------------------------------------------------
INSERT INTO `item_pedido` (`codigo`, `cod_usuario`, `nome_produto`, `observacao`, `preco_und`, `quantidade`) VALUES
  (1, 1, 'Pizza Calabresa Artesanal', 'Sem cebola, borda recheada de catupiry', 49.90, 1),
  (2, 1, 'Refrigerante Lata 350ml', 'Coca-Cola bem gelada com gelo e limão', 6.50, 2),
  (3, 2, 'Pizza Margherita Especial', 'Bem assada', 46.00, 1)
ON DUPLICATE KEY UPDATE
  `nome_produto` = VALUES(`nome_produto`),
  `quantidade` = VALUES(`quantidade`);
