-- EmprestaTI · Aula 9 · Modelo de dados
-- Rode este bloco no phpMyAdmin, na aba SQL

CREATE DATABASE IF NOT EXISTS empresta_ti;
USE empresta_ti;

CREATE TABLE IF NOT EXISTS equipamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  patrimonio VARCHAR(30) NOT NULL UNIQUE,
  tipo VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS emprestimos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  equipamento_id INT NOT NULL,
  servidor VARCHAR(120) NOT NULL,
  data_retirada DATE NOT NULL,
  data_prevista_devolucao DATE NOT NULL,
  data_devolucao DATE NULL,
  FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id)
);
