<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Senhas_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // 1) Conta quantas senhas de um tipo foram geradas hoje
    public function count_by_tipo_and_date($tipo_id, $date)
    {
        return $this->db
            ->where('tipo_senha_id', $tipo_id)
            ->where('DATE(data_criacao)', $date)
            ->count_all_results('senhas');
    }

    // 2) Conta quantas senhas de um subtipo foram geradas hoje
    public function count_by_subtipo_and_date($subtipo_id, $date)
    {
        return $this->db
            ->where('subtipo_id', $subtipo_id)
            ->where('DATE(data_criacao)', $date)
            ->count_all_results('senhas');
    }

    // 3) Insere nova senha de tipo, com data e hora
    public function insert_senha($tipo_id, $numero, $senha, $date)
    {
        $data = [
            'tipo_senha_id' => $tipo_id,
            'numero'        => $numero,
            'senha'         => $senha,
            'data_criacao'  => $date,
            'status'      => 'pendente'
        ];

        return $this->db->insert('senhas', $data);
    }

    // 4) Insere nova senha de subtipo, com data e hora
    public function insert_senha_subtipo($subtipo_id, $tipo_id, $numero, $senha, $date)
    {
        $data = [
            'subtipo_id'     => $subtipo_id,
            'tipo_senha_id'  => $tipo_id,
            'numero'         => $numero,
            'senha'          => $senha,
            'data_criacao'   => $date,
            'status'       => 'pendente'
        ];

        return $this->db->insert('senhas', $data);
    }

    // --- Seus métodos originais abaixo, sem alterações ---
    public function get_senhas_disponiveis()
    {
        return $this->db->where('status', 'pendente')->get('senhas')->result();
    }

    public function get_pacientes()
    {
        return $this->db->where('status', 'aguardando')->get('pacientes')->result();
    }

    public function update_status_senha($senha, $status)
    {
        $this->db->where('senha', $senha)->update('senhas', ['status' => $status]);
    }

    public function get_senha_atual()
    {
        return $this->db
            ->select('senha, guiche')
            ->where('status', 'pendente')
            ->order_by('id', 'desc')
            ->limit(1)
            ->get('senhas')
            ->row();
    }

    public function get_paciente_atual()
    {
        return $this->db
            ->select('nome_paciente, consultorio')
            ->where('status', 'chamada')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('pacientes')
            ->row();
    }

    public function salvar_chamada($paciente, $sala)
    {
        return $this->db->insert('chamadas', [
            'paciente'   => $paciente,
            'sala'       => $sala,
            'chamado_em' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_historico_chamadas($limit = 4)
    {
        return $this->db
            ->order_by('chamado_em', 'DESC')
            ->get_where('senhas', ['status' => 'chamado'], $limit)
            ->result_array();
    }

    public function chamar_senha()
    {
        $id_senha = $this->input->post('id_senha');
        $guiche   = $this->input->post('guiche');

        if ($id_senha && $guiche) {
            $this->update_status_senha($id_senha, 'chamado');
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao chamar senha.']);
        }
    }

    public function getUltimasChamadas()
    {
        return $this->db
            ->order_by('data_hora', 'DESC')
            ->limit(4)
            ->get('chamadas')
            ->result_array();
    }
}
