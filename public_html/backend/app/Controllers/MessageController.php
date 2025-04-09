<?php
namespace App\Controllers;

use App\Libraries\WebSocketServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class MessageController extends BaseController
{
    // startet den websocket-server auf port 8080
    public function startWebSocket()
    {
        // erstellt den websocket-server mit http- und websocket-handler
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketServer()
                )
            ),
            8080 // websocket-port
        );

        // ausgabe zur bestätigung, dass der server läuft
        echo "websocket-server läuft auf port 8080...\n";

        // startet den server und wartet auf verbindungen
        $server->run();
    }
}
