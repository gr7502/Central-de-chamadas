<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pacientes_model');
        $this->load->model('Configuration_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index()
    {
        $data['pacientes'] = $this->Pacientes_model->get_all_pacientes();
        $this->loadView('pacientes', $data, 'Lista de Pacientes');
    }

    public function home()
    {
        $this->loadView('welcome/index', [], 'Home');
    }

    public function create_paciente()
    {
        if ($this->form_validation->run('paciente_validation') == FALSE) {
            $this->load->view('paciente_form');
        } else {
            $this->Pacientes_model->create_paciente();
            redirect('paciente/index');
        }
    }

    public function store()
    {
        $nome = $this->input->post('nome');
        $nascimento = $this->input->post('nascimento');
        $cpf = $this->input->post('cpf');
        $email = $this->input->post('email');
        $endereco = $this->input->post('endereco');

        $data_parts = explode('/', $nascimento);
        if (count($data_parts) == 3 && checkdate($data_parts[1], $data_parts[0], $data_parts[2])) {
            $nascimento_db = $data_parts[2] . '-' . $data_parts[1] . '-' . $data_parts[0];
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data de nascimento inválida! Corrija o campo e tente novamente.'
            ]);
            return;
        }

        $this->Pacientes_model->insert_pacientes([
            'nome' => $nome,
            'nascimento' => $nascimento_db,
            'cpf' => $cpf,
            'email' => $email,
            'endereco' => $endereco
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Paciente cadastrado com sucesso!'
        ]);
    }

    public function editar()
    {
        $id = $this->uri->segment(3);
        $data['paciente'] = $this->Pacientes_model->get_all_pacientes_by_id($id);
        $this->load->view('paciente_form', $data);
    }

    public function atualizar()
    {
        $id = $this->uri->segment(3);
        $data = array(
            'nome' => $this->input->post('nome'),
            'nascimento' => $this->input->post('nascimento'),
            'cpf' => $this->input->post('cpf'),
            'email' => $this->input->post('email'),
            'endereco' => $this->input->post('endereco')
        );

        $this->Pacientes_model->update_pacientes($data, $id);
        redirect('paciente/index');
    }

    public function delete_paciente()
    {
        $id = $this->uri->segment(3);
        $this->Pacientes_model->delete_pacientes($id);
        redirect('paciente/index');
    }

    public function check_cpf()
    {
        $cpf = $this->input->post('cpf');
        $id = $this->input->post('id');
        $exists = $this->Pacientes_model->cpf_exists($cpf, $id);
        echo json_encode(['exists' => $exists]);
    }
}
