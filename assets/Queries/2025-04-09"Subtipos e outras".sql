CREATE TABLE subtipos_senha (
    id SERIAL PRIMARY KEY,
    tipo_senha_id INTEGER NOT NULL,
    nome VARCHAR(100) NOT NULL,
    prefixo VARCHAR(10) NOT NULL,
    FOREIGN KEY (tipo_senha_id) REFERENCES tipos_senha(id) ON DELETE CASCADE
);

alter table senhas add subtipo_id int;



SELECT cron.schedule(
    'truncate_diario',
    '0 0 * * *',
    'TRUNCATE TABLE senhas, fila_chamadas RESTART IDENTITY CASCADE'
);