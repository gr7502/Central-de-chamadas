alter table fila_chamadas add column hora_finalizacao timestamp;

-- Exemplo de adição de coluna se necessário
ALTER TABLE senhas ADD COLUMN id_fila_chamada INTEGER REFERENCES fila_chamadas(id);


alter table fila_chamadas rename consultorio to sala;


alter table fila_chamadas add column consultorio varchar (255);


CREATE TABLE IF NOT EXISTS configurations (
    id SERIAL PRIMARY KEY,
    image_url VARCHAR(255) DEFAULT NULL,
    primary_color VARCHAR(50) DEFAULT '#6a5acd'
);