<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chamada extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Senhas_model');
        $this->load->model('Pacientes_model');
        $this->load->model('Configuration_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->model('Pacientes_model');
        $this->load->model('Senhas_model');

        $data['config'] = $this->Configuration_model->get_config();
        $data['senhas'] = $this->Senhas_model->get_senhas_disponiveis();
        $data['pacientes'] = $this->Pacientes_model->get_all_pacientes();
        $ultimos_chamados = $this->Senhas_model->get_historico_chamadas();
        $data['ultimos_chamados'] = !empty($ultimos_chamados) ? $ultimos_chamados : []; 
        $this->load->view('chamada', $data);
    }
    public function chamar() {
        header('Content-Type: application/json');
    
        $tipo = $this->input->post('tipo');
        $senha = $this->input->post('senha');
        $guiche = $this->input->post('guiche');
        $paciente = $this->input->post('paciente');
        $sala = $this->input->post('sala');
    
        if ($tipo === 'senha') {
            if ($senha && $guiche) {
                $mensagem = "Senha: {$senha}, Dirija-se ao {$guiche}";
    
               
                $this->db->insert('chamadas', [
                    'tipo' => 'senha',
                    'senha' => $senha,
                    'guiche' => $guiche,
                    'mensagem' => $mensagem,
                    'data_hora' => date('Y-m-d H:i:s')
                ]);
    
                echo json_encode(['status' => 'success', 'mensagem' => $mensagem]);
                return; 
            } else {
                echo json_encode(['status' => 'error', 'mensagem' => 'Selecione um guichê e uma senha!']);
                return;
            }
        }
    
        if ($tipo === 'paciente') {
            if ($paciente && $sala) {
                $mensagem = "Paciente: {$paciente}, Dirija-se ao {$sala}";
    
                // Inserir no banco de dados
                $this->db->insert('chamadas', [
                    'tipo' => 'paciente',
                    'paciente' => $paciente,
                    'consultorio' => $sala,
                    'mensagem' => $mensagem,
                    'data_hora' => date('Y-m-d H:i:s')
                ]);
    
                echo json_encode(['status' => 'success', 'mensagem' => $mensagem]);
                return;
            } else {
                echo json_encode(['status' => 'error', 'mensagem' => 'Selecione um paciente e uma sala!']);
                return;
            }
        }
    
        // Se o tipo não for nem senha nem paciente, retorna erro
        echo json_encode(['status' => 'error', 'mensagem' => 'Tipo de chamada inválido!']);
    }
    
    
    public function salvar_chamada($tipo, $dados)
{
    $data = [
        'tipo' => $tipo,
        'data_hora' => date('Y-m-d H:i:s')
    ];

    if ($tipo == 'senha') {
        $data['senha'] = $dados['senha'];
        $data['guiche'] = $dados['guiche'];
    } elseif ($tipo == 'paciente') {
        $data['paciente'] = $dados['paciente'];
        $data['consultorio'] = $dados['consultorio'];
    }

    return $this->db->insert('chamadas', $data);
}


    public function get_chamadas() {
        $senha_atual = $this->Senhas_model->get_senha_atual();
        $historico = $this->Senhas_model->get_historico_chamadas();

        echo json_encode([
            "senha_atual" => $senha_atual,
            "historico" => $historico
        ]);
    }

   
    public function senha_chamada(){
    $this->load->model('Senhas_model'); // Carregar o model

    $senha = $this->Senhas_model->get_senha_atual(); // Buscar a senha atual

    if ($senha) {
        $response = [
            'senha' => $senha->codigo,
            'paciente' => $senha->nome_paciente,
            'medico' => $senha->medico,
            'consultorio' => $senha->consultorio,
            'guiche' => $senha->guiche
        ];
    } else {
        $response = ['erro' => 'Nenhuma senha chamada no momento.'];
    }

    echo json_encode($response);
}

public function registrar_chamada() {
    $tipo = $this->input->post('tipo');
    $mensagem = $this->input->post('mensagem');

    // Salvar a mensagem na sessão
    $this->session->set_userdata('ultima_chamada', $mensagem);

    echo json_encode(['status' => 'success']);
}


public function getUltimaChamada() {
    header('Content-Type: application/json');

    $query = $this->db->order_by('data_hora', 'DESC')->get('chamadas', 1);
    $ultimaChamada = $query->row();

    if ($ultimaChamada) {
        echo json_encode(['status' => 'success', 'mensagem' => $ultimaChamada->mensagem]);
    } else {
        echo json_encode(['status' => 'error', 'mensagem' => 'Nenhuma senha chamada']);
    }
}

public function chamar_senha()
{
    $senha_id = $this->input->post('senha_id'); // Recebe a senha via POST

    // Busca os dados da senha no banco de dados
    $senha = $this->db->get_where('senhas', ['id' => $senha_id])->row();

    if ($senha) {
        // Salva a senha chamada na sessão
        $this->session->set_userdata('senha_chamada', $senha->nome);

        echo json_encode(['status' => 'success', 'senha' => $senha->nome]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Senha não encontrada']);
    }
}

public function getProximaChamada() {
    // Pega a próxima chamada pendente
    $query = $this->db->query("
        SELECT c.* 
        FROM fila_chamadas f
        JOIN chamadas c ON f.chamada_id = c.id
        WHERE f.status = 'pendente'
        ORDER BY f.data_entrada ASC
        LIMIT 1
    ");

    $chamada = $query->row_array();

    if ($chamada) {
        // Marca como "falando" para evitar duplicação
        $this->db->where('chamada_id', $chamada['id']);
        $this->db->update('fila_chamadas', ['status' => 'falando']);
    }

    echo json_encode($chamada ? [
        'status' => 'success',
        'mensagem' => $chamada['mensagem'],
        'chamada_id' => $chamada['id']
    ] : [
        'status' => 'empty'
    ]);
}



}


