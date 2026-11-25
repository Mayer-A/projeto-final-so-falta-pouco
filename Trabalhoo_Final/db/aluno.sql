/* ===================================================
   1. CRIAÇÃO E SELEÇÃO DO BANCO DE DADOS
   =================================================== */
CREATE DATABASE IF NOT EXISTS aluno CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE aluno;

/* ===================================================
   2. CRIAÇÃO DA TABELA DE ALUNOS
   =================================================== */
CREATE TABLE IF NOT EXISTS aluno (
    pk_codigo_aluno SERIAL PRIMARY KEY,   -- código único, auto incremento
    nome      VARCHAR(20)  NOT NULL,
    sobrenome VARCHAR(20)  NOT NULL,
    idade     INT          NOT NULL,
    email     VARCHAR(50)  NOT NULL UNIQUE,
    senha     VARCHAR(255) NOT NULL,      -- 255: o password_hash() gera ~60 caracteres
    adm       BOOLEAN      NOT NULL DEFAULT FALSE
);

/* Senhas em texto puro: o login.php converte para hash no primeiro acesso */
INSERT INTO aluno (nome, sobrenome, idade, email, senha, adm) VALUES
('Logan', 'Wolverine', 137, 'wolverine@xmen.com', 'adm123', true),
('Scott', 'Summers', 28, 'ciclope@xmen.com', 'ciclope123', false),
('Jean', 'Grey', 27, 'jean@xmen.com', 'jean123', false);
