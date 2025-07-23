CREATE TABLE fila_chamadas (
    id SERIAL PRIMARY KEY,
    tipo VARCHAR(10) NOT NULL CHECK (tipo IN ('senha', 'paciente')),
    senha VARCHAR(50),
    senha_id INT,
    guiche VARCHAR(50),
    paciente VARCHAR(255),
    paciente_id INT,
    consultorio VARCHAR(100),
    mensagem TEXT NOT NULL,
    status VARCHAR(10) DEFAULT 'pendente' CHECK (status IN ('pendente', 'falando', 'completa')),
    data_entrada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_inicio_fala TIMESTAMP,
    data_fim_fala TIMESTAMP
);

-- Adição de nova tabela para fila de chamada.