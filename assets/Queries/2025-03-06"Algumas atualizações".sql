ALTER TABLE senhas ADD COLUMN status VARCHAR(20) DEFAULT 'pendente';


ALTER TABLE senhas ADD COLUMN chamado_em TIMESTAMP NULL;


ALTER TABLE pacientes ADD COLUMN status VARCHAR(20) DEFAULT 'aguardando';

--As atualizações acima precisei fazer pra testar a questão do painel.