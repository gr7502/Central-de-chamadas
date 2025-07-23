<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require dirname(__DIR__) . '/vendor/autoload.php';

class CallServer implements MessageComponentInterface {
    protected $clients;
    protected $ci;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        // Carrega o CodeIgniter para acessar o banco de dados
        $this->ci = &get_instance();
        $this->ci->load->database();
        
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nova conexão! ({$conn->resourceId})\n";

        // Envia todas as chamadas pendentes ao cliente recém-conectado
        $this->sendPendingCalls($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Pode ser usado para receber mensagens do cliente, se necessário
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Conexão fechada! ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }

    // Função para buscar e enviar chamadas pendentes
    public function sendPendingCalls($conn = null) {
        $query = $this->ci->db->where('status', 'pendente')
                              ->where('falada', FALSE)
                              ->order_by('data_entrada', 'ASC')
                              ->get('fila_chamadas')
                              ->result_array();

        $calls = [];
        foreach ($query as $call) {
            $calls[] = [
                'fila_id' => $call['id'],
                'tipo' => $call['tipo'],
                'number' => $call['tipo'] === 'senha' ? $call['senha'] : $call['paciente'],
                'guiche' => $call['guiche'],
                'sala' => $call['consultorio'],
                'mensagem' => $call['mensagem'],
                'data_entrada' => $call['data_entrada']
            ];
        }

        $message = json_encode([
            'type' => 'pending_calls',
            'calls' => $calls
        ]);

        if ($conn) {
            // Envia apenas para o cliente recém-conectado
            $conn->send($message);
        } else {
            // Envia para todos os clientes conectados
            foreach ($this->clients as $client) {
                $client->send($message);
            }
        }
    }

    // Função para notificar sobre uma nova chamada
    public function notifyNewCall($call) {
        $message = json_encode([
            'type' => 'new_call',
            'call' => [
                'fila_id' => $call['id'],
                'tipo' => $call['tipo'],
                'number' => $call['tipo'] === 'senha' ? $call['senha'] : $call['paciente'],
                'guiche' => $call['guiche'],
                'sala' => $call['consultorio'],
                'mensagem' => $call['mensagem'],
                'data_entrada' => $call['data_entrada']
            ]
        ]);

        foreach ($this->clients as $client) {
            $client->send($message);
        }
    }
}

// Inicia o servidor WebSocket
$server = \Ratchet\Server\IoServer::factory(
    new \Ratchet\Http\HttpServer(
        new \Ratchet\WebSocket\WsServer(
            new CallServer()
        )
    ),
    8080
);

$server->run();