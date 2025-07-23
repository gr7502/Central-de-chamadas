<?php
class Chamada_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Obtém a última chamada registrada
    public function get_ultima_chamada() {
        return $this->db->order_by('id', 'DESC')
                       ->limit(1)
                       ->get('fila_chamadas')
                       ->row_array();
    }

   
    public function adicionar_fila($dados) {
        // Validação básica
        if (empty($dados) || !isset($dados['tipo'])) {
            log_message('error', 'Dados inválidos para adicionar fila');
            return false;
        }
    
      
        $dados_insercao = [
            'tipo' => $dados['tipo'],
            'status' => 'pendente',
            'data_entrada' => date('Y-m-d H:i:s'),
            'mensagem' => $this->gerar_mensagem($dados)
        ];
    
        // Adiciona campos específicos
        if ($dados['tipo'] === 'senha') {
            $dados_insercao['senha'] = $dados['senha'];
            $dados_insercao['guiche'] = $dados['guiche'];
            $dados_insercao['senha_id'] = $this->buscar_id_senha($dados['senha']);
        } else {
            $dados_insercao['paciente'] = $dados['paciente'];
            $dados_insercao['consultorio'] = $dados['sala'];
            $dados_insercao['paciente_id'] = $this->buscar_id_paciente($dados['paciente']);
        }
    
        return $this->db->insert('fila_chamadas', $dados_insercao);
    }
    
    private function gerar_mensagem($dados) {
        if ($dados['tipo'] === 'senha') {
            return "Senha: {$dados['senha']}, dirija-se ao {$dados['guiche']}";
        }
        return "Paciente: {$dados['paciente']}, dirija-se ao {$dados['sala']}";
    }
    
    private function buscar_id_senha($senha) {
        $result = $this->db->select('id')
                          ->where('senha', $senha)
                          ->get('senhas')
                          ->row_array();
        return $result ? $result['id'] : null;
    }
    
    private function buscar_id_paciente($paciente) {
        $result = $this->db->select('id')
                          ->where('nome', $paciente)
                          ->get('pacientes')
                          ->row_array();
        return $result ? $result['id'] : null;
    }

    
    public function get_proxima_chamada() {
        $this->db->where('status', 'pendente');
        $this->db->order_by('data_entrada', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('fila_chamadas');
        return $query->row_array();
    }
   
    public function comecar_falar($id) {
        $this->db->where('id', $id);
        $this->db->update('fila_chamadas', ['status' => 'falando']);
    }

    public function finalizar_fala($id) {
        $this->db->where('id', $id);
        $this->db->update('fila_chamadas', [
            'status' => 'finalizada',
            'data_finalizacao' => date('Y-m-d H:i:s')
        ]);
    }

    // Verifica se a chamada foi recentemente falada
    public function foi_falada_recentemente($id, $segundos = 30) {
        // Determina qual campo usar baseado no tipo
        $this->db->group_start();
        $this->db->where('senha_id', $id);
        $this->db->or_where('paciente_id', $id);
        $this->db->group_end();
        
        $this->db->where('data_fim_fala >=', date('Y-m-d H:i:s', time() - $segundos));
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get('fila_chamadas')->row_array();
    }

    public function get_ultima_por_tipo($tipo) {
        $this->db->where('tipo', $tipo);
        $this->db->order_by('data_entrada', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('fila_chamadas');
        
        return $query->num_rows() > 0 ? $query->row_array() : null;
    }

    public function getUltimasChamadas(){
        $this->db->order_by('data_hora', 'DESC');
        $this->db->limit(4);
        return $this->db->get('fila_chamadas')->result_array();
    }

    public function get_ultimas_chamadas($limit = 8) {
        $this->db->select('tipo, senha, paciente, guiche, sala, data_entrada');
        $this->db->where('DATE(data_entrada)', date('Y-m-d')); // Filtra por data atual
        $this->db->order_by('data_entrada', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('fila_chamadas')->result_array();
    }

    
    public function buscar_proxima_senha() {
        return $this->db->select('*')
                        ->from('senhas')
                        ->where('status', 'pendente')
                        ->order_by('data_criacao', 'ASC')
                        ->limit(1)
                        ->get()
                        ->row();
    }
    
    public function registrar_chamada($dados) {
        // Validação dos dados antes de inserir
        $camposObrigatorios = ['tipo', 'status', 'data_entrada'];
        foreach ($camposObrigatorios as $campo) {
            if (!isset($dados[$campo])) {
                return false;
            }
        }
    
        // Insere na tabela de chamadas
        return $this->db->insert('fila_chamadas', $dados);
    }
    
    public function finalizar_chamada($id) {
        return $this->db
        ->where('id', $id)
        ->update('senhas', [
            'status'           => 'finalizada',
            'hora_finalizacao' => date('Y-m-d H:i:s'),
        ]);
    }
    
    public function obter_chamadas_ativas() {
        return $this->db->select('*')
                        ->from('fila_chamadas')
                        ->where('status', 'pendente')
                        ->order_by('data_entrada', 'ASC')
                        ->get()
                        ->result();
    }

    public function registrar_chamada_paciente($paciente, $sala) {
        $data = [
            'paciente' => $paciente,
            'consultorio' => $sala, // Alterado de 'sala' para 'consultorio'
            'data_chamada' => date('Y-m-d H:i:s'),
            'status' => 'em_atendimento',
            'tipo' => 'paciente'
        ];
        
        $this->db->insert('fila_chamadas', $data);
        
        return $this->db->insert_id();
    }

    public function get_senhas_pendentes() {
        return $this->db->where('status', 'pendente')
                        ->get('senhas')
                        ->result();
    }

    // Obtém as últimas senhas chamadas ou finalizadas da tabela 'senhas'
    public function get_ultimas_chamadas_senhas($limit = 5) {
        return $this->db->where('status !=', 'pendente')
                        ->order_by('id', 'DESC')
                        ->limit($limit)
                        ->get('senhas')
                        ->result();
    }

    // Finaliza uma senha específica na tabela 'senhas'
    public function finalizar_senha($id) {
        $this->db->where('id', $id)
                 ->update('senhas', [
                     'status' => 'finalizada',
                     'hora_finalizacao' => date('Y-m-d H:i:s')
                 ]);
    }

    public function buscar_proxima_senha_hoje(){
    $hoje = date('Y-m-d');
    return $this->db
        ->where('status', 'pendente')
        ->where("DATE(data_criacao) =", $hoje)  // só hoje
        ->order_by('numero', 'ASC')
        ->limit(1)
        ->get('senhas')
        ->row();
}
}