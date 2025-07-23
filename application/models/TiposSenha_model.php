<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TiposSenha_model extends CI_Model {

    public function __construct() {
        parent::__construct();        
        $this->load->database();
    }

    // Métodos para Tipos de Senha (já existentes)
    public function get_all() {
        return $this->db->get('tipos_senha')->result();
    }

    public function insert_tipo_senha($nome, $prefixo) {
        $data = [
            'nome' => $nome,
            'prefixo' => $prefixo
        ];
        $this->db->insert('tipos_senha', $data);
    }

    public function update_tipo($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('tipos_senha', $data);
    }

    public function get_tipo_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tipos_senha');
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('tipos_senha');
    }

    // Métodos para Subtipos de Senha (novos)
    public function get_all_subtipos() {
        $this->db->select('subtipos_senha.*, tipos_senha.nome as tipo_nome, tipos_senha.prefixo as tipo_prefixo');
        $this->db->from('subtipos_senha');
        $this->db->join('tipos_senha', 'subtipos_senha.tipo_senha_id = tipos_senha.id');
        return $this->db->get()->result();
    }

    public function get_subtipos_by_tipo($tipo_id) {
        $this->db->where('tipo_senha_id', $tipo_id);
        $query = $this->db->get('subtipos_senha');
        return $query->result();
    }

    public function insert_subtipo_senha($tipo_senha_id, $nome, $prefixo) {
        $data = [
            'tipo_senha_id' => $tipo_senha_id,
            'nome' => $nome,
            'prefixo' => $prefixo
        ];
        $this->db->insert('subtipos_senha', $data);
    }

    public function get_subtipo_by_id($subtipo_id) {
        $this->db->where('id', $subtipo_id);
        $query = $this->db->get('subtipos_senha');
        return $query->row();
    }

    public function update_subtipo($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('subtipos_senha', $data);
    }

    public function delete_subtipo($id) {
        $this->db->where('id', $id);
        $this->db->delete('subtipos_senha');
    }

    public function has_subtipos($tipo_id) {
        $this->db->where('tipo_senha_id', $tipo_id);
        $query = $this->db->get('subtipos_senha');
        return $query->num_rows() > 0;
    }

    


}