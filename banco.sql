CREATE DATABASE IF NOT EXISTS nexustech
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE nexustech;

CREATE TABLE IF NOT EXISTS noticias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    descricao TEXT NOT NULL
);

-- Alguns registros iniciais para testar a listagem
INSERT INTO noticias (titulo, categoria, descricao) VALUES
('Inteligência artificial', 'Tecnologia', 'A inteligência artificial está presente em ferramentas usadas no dia a dia.'),
('Aplicativos úteis', 'Aplicativos', 'Aplicativos podem ajudar na organização de tarefas e compromissos.');
