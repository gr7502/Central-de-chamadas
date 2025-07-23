CREATE TABLE painel_midia (
    id SERIAL PRIMARY KEY,
    caminho VARCHAR(255) NOT NULL,
    tipo TEXT CHECK (tipo IN ('imagem', 'video')) NOT NULL,
    ativo BOOLEAN DEFAULT FALSE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE painel_midia ADD COLUMN nome VARCHAR(255);