<?php
require 'vendor/autoload.php';
require_once "cfg.php";


use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;

class ChatServer implements MessageComponentInterface {
    protected $clients;
    protected $users;
    protected $user;
    protected $chat;    
    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->users = [];
        $this->user = new User();
        $this->chat = new Chat();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Połączenie otwarte: ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        

        $data = json_decode($msg, true);

        if (isset($data['user_id'])) {
            $this->users[$data['user_id']] = $from;
            echo "Użytkownik {$data['user_id']} został zarejestrowany.\n";
            $this->user->status($data['user_id'], 'online');
            return;
        }

        $sender_id = $data['sender_id'];
        $receiver_id = $data['receiver_id'];
        $message = $data['message'];
        
        $this->chat->sendMessage($sender_id, $receiver_id, $message);
        if (isset($this->users[$receiver_id])) {
            $this->users[$receiver_id]->send(json_encode($data));
        }
        
    }

    public function onClose(ConnectionInterface $conn) {
        // Usuń użytkownika z listy połączeń
        foreach ($this->users as $user_id => $client) {
            if ($client === $conn) {
                unset($this->users[$user_id]);
                echo "Użytkownik {$user_id} rozłączony.\n";
                $this->user->status($user_id, 'offline');
                break;
            }
        }
        
        $this->clients->detach($conn);
        echo "Połączenie zamknięte: ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Błąd: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Uruchomienie serwera WebSocket
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080
);

echo "Serwer WebSocket działa na porcie 8080...\n";
$server->run();