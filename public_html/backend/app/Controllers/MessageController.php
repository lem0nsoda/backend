<?php
namespace App\Controllers;

use App\Libraries\WebSocketServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class MessageController extends BaseController
{
    public function startWebSocket()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketServer()
                )
            ),
            8080 // WebSocket Port
        );

        echo "WebSocket-Server läuft auf Port 8080...\n";
        $server->run();
    }


}
