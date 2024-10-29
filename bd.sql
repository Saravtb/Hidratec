-- Remover o banco de dados caso já exista
DROP DATABASE IF EXISTS sistema_cadastro;

-- Criar o banco de dados
CREATE DATABASE sistema_cadastro;

-- Informar que este será o banco em uso
USE sistema_cadastro;

-- Criar a tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Criar a tabela de funcionários
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefone VARCHAR(20)
);

-- Criar a tabela de serviços relacionada via FK com a tabela de funcionários
CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    funcionario_id INT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2),
    concluido TINYINT(1) DEFAULT 0, -- Indica se o serviço foi concluído (0 para não, 1 para sim)
    FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id)
);

-- Inserir usuários no banco
INSERT INTO usuarios (usuario, senha) VALUES ('admin', MD5('admin123'));
INSERT INTO usuarios (usuario, senha) VALUES ('ramon', MD5('ramon123'));
INSERT INTO usuarios (usuario, senha) VALUES ('giba', MD5('giba123'));
INSERT INTO usuarios (usuario, senha) VALUES ('paulão', MD5('paulão123'));
INSERT INTO usuarios (usuario, senha) VALUES ('alves', MD5('alves123'));
INSERT INTO usuarios (usuario, senha) VALUES ('marcos', MD5('marcos123'));


