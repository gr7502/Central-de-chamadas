<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chamada2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chamada_model');
    }

    // Endpoint para processar chamada de senha ou paciente
    public function processar_chamada() {
        header('Content-Type: application/json');
        $data = json_decode($this->input->raw_input_stream, true);
    
        try {
            if (empty($data['tipo'])) {
                throw new Exception('Tipo de chamada não informado');
            }
    
            // 1) CHAMADA DE SENHA (só pendentes de hoje)
            if ($data['tipo'] === 'senha') {
                if (empty($data['guiche'])) {
                    throw new Exception('Guichê não informado');
                }
    
                $senhaObj = $this->Chamada_model->buscar_proxima_senha_hoje();
                if (!$senhaObj) {
                    throw new Exception('Não há senhas pendentes hoje');
                }
    
                $registro = [
                    'tipo'         => 'senha',
                    'mensagem'     => "Senha {$senhaObj->senha}, dirija-se ao {$data['guiche']}",
                    'senha'        => $senhaObj->senha,
                    'guiche'       => $data['guiche'],
                    'data_entrada' => date('Y-m-d H:i:s'),
                    'status'       => 'pendente',
                ];
                $this->Chamada_model->registrar_chamada($registro);
    
                echo json_encode([
                    'status'   => 'success',
                    'message'  => $registro['mensagem'],
                    'senha_id' => $senhaObj->id,
                    'senha'    => $senhaObj->senha,
                    'guiche'   => $data['guiche'],
                ]);
                return;
            }
    
            // 2) CHAMADA DE PACIENTE (igual antes)
            if ($data['tipo'] === 'paciente') {
                if (empty($data['paciente']) || empty($data['sala'])) {
                    throw new Exception('Paciente ou sala não informados');
                }
    
                $registro = [
                    'tipo'         => 'paciente',
                    'mensagem'     => "Paciente {$data['paciente']}, dirija-se ao {$data['sala']}",
                    'paciente'     => $data['paciente'],
                    'sala'         => $data['sala'],
                    'data_entrada' => date('Y-m-d H:i:s'),
                    'status'       => 'pendente',
                ];
                $this->Chamada_model->registrar_chamada($registro);
    
                echo json_encode([
                    'status'   => 'success',
                    'message'  => $registro['mensagem'],
                    'paciente' => $data['paciente'],
                    'sala'     => $data['sala'],
                ]);
                return;
            }
    
            throw new Exception('Tipo de chamada inválido');
    
        } catch (Exception $e) {
            echo json_encode([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
    

    // Endpoint para finalizar atendimento
    public function finalizar_atendimento() {
        header('Content-Type: application/json');
        $data = json_decode($this->input->raw_input_stream, true);

        if (empty($data['id'])) {
            echo json_encode(['status'=>'error','message'=>'ID não informado']);
            return;
        }

        $ok = $this->Chamada_model->finalizar_chamada($data['id']);
        echo json_encode($ok
            ? ['status'=>'success','message'=>'Atendimento finalizado']
            : ['status'=>'error','message'=>'Erro ao finalizar']
        );
    }   

    // Endpoint para listar senhas pendentes
    public function senhas_pendentes() {
        header('Content-Type: application/json');
        $senhas = $this->Chamada_model->get_senhas_pendentes();
        echo json_encode(['status' => 'success', 'senhas' => $senhas]);
    }

    // Endpoint para listar últimas chamadas
    public function ultimas_chamadas() {
        header('Content-Type: application/json');

        // Monta consulta: inclui id da fila como senha_id
        $this->db->select("
            fc.id        AS senha_id,
            fc.tipo      AS tipo,
            fc.senha     AS senha,
            fc.guiche    AS guiche,
            fc.paciente  AS paciente,
            fc.sala      AS sala,
            fc.data_entrada
        ");
        $this->db->from('fila_chamadas fc');
        $this->db->where('fc.status !=', 'finalizada');
        $this->db->order_by('fc.data_entrada', 'DESC');
        $this->db->limit(10);
        $lista = $this->db->get()->result_array();

        echo json_encode([
            'status'           => 'success',
            'ultimas_chamadas' => $lista
        ]);
    }

    // Métodos existentes mantidos
    public function get_ultima_chamada() {
        $ultima_chamada = $this->Chamada_model->get_ultima_chamada();

        if ($ultima_chamada) {
            $id = ($ultima_chamada['tipo'] === 'senha') ? $ultima_chamada['senha_id'] : $ultima_chamada['paciente_id'];
            $foi_falada = $this->Chamada_model->foi_falada_recentemente($id);

            $response = [
                'status' => 'success',
                'chamada' => $ultima_chamada,
                'chamada_nova' => !$foi_falada
            ];
        } else {
            $response = ['status' => 'empty'];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_proxima_chamada() {
        $chamada = $this->Chamada_model->get_proxima_chamada();
        
        if ($chamada) {
            $this->Chamada_model->comecar_falar($chamada['id']);
            
            $response = [
                'status' => 'success',
                'mensagem' => $chamada['mensagem'],
                'fila_id' => $chamada['id'],
                'tipo' => $chamada['tipo'],
                'dados' => [
                    'senha'    => isset($chamada['senha']) ? $chamada['senha'] : null,
                    'guiche'   => isset($chamada['guiche']) ? $chamada['guiche'] : null,
                    'paciente' => isset($chamada['paciente']) ? $chamada['paciente'] : null,
                    'sala'     => isset($chamada['sala']) ? $chamada['sala'] : null
                ]
            ];
        } else {
            $response = ['status' => 'empty'];
        }
        
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($response));
    }

    public function marcar_como_falada($fila_id) {
        $result = $this->Chamada_model->finalizar_fala($fila_id);
        
        $response = $result 
            ? ['status' => 'success'] 
            : ['status' => 'error', 'message' => 'Falha ao atualizar status'];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function proxima_senha() {
        $guiche = $this->input->post('guiche');
    
        $this->db->trans_start();
        $senha = $this->Chamada_model->buscar_proxima_senha();
        
        if ($senha) {
            $this->Chamada_model->registrar_chamada([
                'senha_id' => $senha->id,
                'senha' => $senha->senha,
                'guiche' => $guiche,
                'data_entrada' => date('Y-m-d H:i:s'),
                'status' => 'ativa'
            ]);
        }
        
        $this->db->trans_complete();
    
        echo json_encode(['status' => $senha ? 'success' : 'error']);
    }

    public function obter_fila() {
        $fila = $this->Chamada_model->obter_chamadas_ativas();
        echo json_encode($fila);
    }

    public function feed_painel() {
        $response = [
            'status' => 'success',
            'ultima_chamada' => $this->Chamada_model->ultima_chamada_ativa(),
            'historico' => $this->Chamada_model->historico_chamadas(5)
        ];
    
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_ultimas_chamadas() {
        $chamadas = $this->Chamada_model->get_ultimas_chamadas(5);
        
        echo json_encode([
            'status' => 'success',
            'chamadas' => $chamadas
        ]);
    }
}