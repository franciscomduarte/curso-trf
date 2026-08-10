-- SISPROT · Aula 0 · Modelo de dados inicial
-- Rode este bloco no phpMyAdmin, na aba SQL

CREATE DATABASE IF NOT EXISTS sisprot;
USE sisprot;

CREATE TABLE IF NOT EXISTS protocolos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero VARCHAR(30) NOT NULL UNIQUE,
  assunto VARCHAR(200) NOT NULL,
  requerente VARCHAR(120) NOT NULL,
  data_abertura DATE NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'Aberto'
);
