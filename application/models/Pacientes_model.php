<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert_pacientes($data) {
        $this->db->insert('pacientes', $data);
        return $this->db->insert_id();
    }
    public function update_pacientes($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('pacientes', $data);
    }
    public function delete_pacientes($id) {
        $this->db->where('id', $id);
        $this->db->delete('pacientes');
    }
    public function get_all_pacientes() {
        $query = $this->db->get('pacientes');
        return $query->result();
    }
    public function get_all_pacientes_by_id($id) {    
        $this->db->where('id', $id);
        $query = $this->db->get('pacientes');
        return $query->row();
    } 

    public function cpf_exists($cpf, $id = null)
{
    $this->db->where('cpf', $cpf);
    if ($id) {
        $this->db->where('id !=', $id);
    }
    return $this->db->get('pacientes')->num_rows() > 0;
}
    
}