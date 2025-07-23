CREATE TABLE pacientes (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    nascimento DATE NOT NULL,
    cpf VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    endereco TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE salas (
    id SERIAL PRIMARY KEY,
    nome_sala VARCHAR(255) NOT null
)

INSERT INTO salas (nome_sala) 
VALUES 
    ('Consultório 01'),
    ('Consultório 02');


    CREATE TABLE tipos_senha (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    prefixo VARCHAR(20) NOT NULL
);

CREATE TABLE senhas (
    id SERIAL PRIMARY KEY,
    tipo_senha_id INT NOT NULL,
    numero INT NOT NULL,
    senha VARCHAR(20) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_senha_id) REFERENCES tipos_senha(id)
);
