CREATE TABLE pizzas (
    idPizza INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    ingredientes VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);
 
INSERT INTO pizzas (nome, ingredientes, valor) VALUES
('Calabresa', 'Mussarela, calabresa fatiada e cebola', 45.50),
('Mussarela', 'Mussarela e molho de tomate', 40.00),
('Frango com Catupiry', 'Frango desfiado, catupiry e mussarela', 52.90),
('Portuguesa', 'Mussarela, presunto, ovo, ervilha, cebola e calabresa', 62.90),
('Moda do Juca', 'Mussarela, peito de peru, palmito, alho poró e alcaparras', 72.50);
 
SELECT * FROM pizzas

CREATE TABLE bebida (
    idBebida INT AUTO_INCREMENT PRIMARY KEY,
    nomeBebida VARCHAR(100) NOT NULL,
    tipoBebida VARCHAR(50),
    volume INT COMMENT 'Volume em ml',
    valor DECIMAL(10, 2) NOT NULL
);

INSERT INTO bebida (nomeBebida, tipoBebida, volume, valor) VALUES 
('Coca-Cola Lata', 'Refrigerante', 350, 6.50),
('Cerveja Skol', 'Cerveja', 350, 5.80),
('Suco de Laranja Natural', 'Suco', 400, 12.00),
('Água Mineral sem Gás', 'Água', 500, 4.50),
('Vinho Tinto de Mesa', 'Vinho', 750, 45.90),
('Guaraná Antarctica 2L', 'Refrigerante', 2000, 10.50);