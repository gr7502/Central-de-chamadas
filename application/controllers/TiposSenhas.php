<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TiposSenhas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('TiposSenha_model');
        $this->load->model('Configuration_model');
        $this->load->library('session');
    }

    // Métodos para Tipos de Senha (já existentes)
    public function index() {
        $data['tipos_senha'] = $this->TiposSenha_model->get_all();
        $data['subtipos_senha'] = $this->TiposSenha_model->get_all_subtipos();
        $data['config'] = $this->Configuration_model->get_config();
        $this->load->view('tp_senha', $data);
    }

    public function criar() {
        $this->load->view('form_tipo_senha');
    }

    public function salvar() {
        $nome = $this->input->post('nome');
        $prefixo = $this->input->post('prefixo');

        if (!empty($nome) && !empty($prefixo)) {
            $this->TiposSenha_model->insert_tipo_senha($nome, $prefixo);
            $this->session->set_flashdata('success', 'Tipo de senha cadastrado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro: Nome e prefixo são obrigatórios.');
        }
        redirect('tiposSenhas/index');
    }

    public function editar($id) {
        $data['tipo_senha'] = $this->TiposSenha_model->get_tipo_by_id($id);
        if (!$data['tipo_senha']) {
            show_404();
        }
        $this->load->view('form_tipo_senha', $data);
    }

    public function atualizar() {
        $id = $this->uri->segment(3);
        $data = [
            'nome' => $this->input->post('nome'),
            'prefixo' => $this->input->post('prefixo'),
        ];
        $this->TiposSenha_model->update_tipo($data, $id);
        $this->session->set_flashdata('success', 'Tipo de senha atualizado com sucesso!');
        redirect('tiposSenhas/index');
    }

    public function delete($id) {
        $this->TiposSenha_model->delete($id);
        $this->session->set_flashdata('success', 'Tipo de senha deletado com sucesso!');
        redirect('tiposSenhas/index');
    }

    // Métodos para Subtipos de Senha (novos)
    public function criar_subtipo() {
        $data['tipos_senha'] = $this->TiposSenha_model->get_all(); // Para o dropdown de tipos
        $this->load->view('form_subtipo_senha', $data);
    }

    public function salvar_subtipo() {
        $tipo_senha_id = $this->input->post('tipo_senha_id');
        $nome = $this->input->post('nome');
        $prefixo = $this->input->post('prefixo');

        if (!empty($tipo_senha_id) && !empty($nome) && !empty($prefixo)) {
            $this->TiposSenha_model->insert_subtipo_senha($tipo_senha_id, $nome, $prefixo);
            $this->session->set_flashdata('success', 'Subtipo de senha cadastrado com sucesso!');
        } else {
            $this->session->set_flashdata('error', 'Erro: Tipo, nome e prefixo são obrigatórios.');
        }
        redirect('tiposSenhas/index');
    }

    public function editar_subtipo($id) {
        $data['subtipo_senha'] = $this->TiposSenha_model->get_subtipo_by_id($id);
        $data['tipos_senha'] = $this->TiposSenha_model->get_all(); // Para o dropdown de tipos
        if (!$data['subtipo_senha']) {
            show_404();
        }
        $this->load->view('form_subtipo_senha', $data);
    }

    public function atualizar_subtipo() {
        $id = $this->uri->segment(3);
        $data = [
            'tipo_senha_id' => $this->input->post('tipo_senha_id'),
            'nome' => $this->input->post('nome'),
            'prefixo' => $this->input->post('prefixo'),
        ];
        $this->TiposSenha_model->update_subtipo($data, $id);
        $this->session->set_flashdata('success', 'Subtipo de senha atualizado com sucesso!');
        redirect('tiposSenhas/index');
    }

    public function delete_subtipo($id) {
        $this->TiposSenha_model->delete_subtipo($id);
        $this->session->set_flashdata('success', 'Subtipo de senha deletado com sucesso!');
        redirect('tiposSenhas/index');
    }
}