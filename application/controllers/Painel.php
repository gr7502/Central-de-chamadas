<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Senhas_model');
        $this->load->model('Chamada_model');
        $this->load->model('Configuration_model');
        $this->load->library('session');
    }

    public function index() {
        
    $data['senha_atual'] = $this->Senhas_model->get_senha_atual();
    $data['ultimasChamadas'] = $this->Chamada_model->get_ultimas_chamadas(6);
    $data['midia_painel'] = $this->Configuration_model->get_config();
        $this->load->view('painel_2', $data);
    }

    public function chamar_senha()
    {
        $senha_id = $this->input->post('senha_id'); // Recebe a senha via POST

        // Busca os dados da senha no banco de dados
        $senha = $this->db->get_where('senhas', ['id' => $senha_id])->row();

        if ($senha) {
            // Salva a senha chamada na sessão
            $this->session->set_userdata('senha_chamada', $senha->senha);

            echo json_encode(['status' => 'success', 'senha' => $senha->senha]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Senha não encontrada']);
        }
    }

    public function get_senha_chamada()
    {
        $senha_chamada = $this->session->userdata('senha_chamada');
        if (!$senha_chamada) {
            $senha_chamada = null;
        }else{
            echo json_encode(['senha' => $senha_chamada]);
        }
        
    }

    public function getUltimasChamadasJson(){
    $ultimasChamadas = $this->Senhas_model->getUltimasChamadas();
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($ultimasChamadas));
}
}


