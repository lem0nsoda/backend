<?php
namespace App\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use CodeIgniter\Database\BaseConnection;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $connectedClients = [];
    protected $db;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;

        // CodeIgniter Database Instanz holen
        $this->db = \Config\Database::connect();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Neue Verbindung ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        echo "Nachricht erhalten: $msg\n";
        $data = json_decode($msg, true);

        if (isset($data['clientID'])) {
            $this->connectedClients[$data['clientID']] = $from;
            echo "Client verbunden: {$data['clientID']}\n";

            // Antwort an den Client senden
            $from->send(json_encode(['status' => 'success', 'clientID' => $data['clientID']]));
        }

        if (isset($data['action']) && $data['action'] === 'showDia') {
            $this->sendImage($data);
        }
    }

    private function sendImage($data)
    {
        $query = $this->db->query("SELECT * FROM images WHERE id = ?", [$data['imageID']]);
        $image = $query->getRow();

        if ($image) {
            $response = [
                'action' => 'showDia',
                'fileType' => $image->mime_type,
                'data' => base64_encode($image->data),
            ];

            foreach ($this->clients as $client) {
                $client->send(json_encode($response));
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Verbindung getrennt ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Fehler: {$e->getMessage()}\n";
        $conn->close();
    }
}
