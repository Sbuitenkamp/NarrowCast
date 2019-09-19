<?php
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use NarrowCast\Server;
require_once  __DIR__ . '/vendor/autoload.php';
require_once  __DIR__ . '/models/Db.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server(new Db())
        )
    ),
    8080,
    "127.0.0.1"
);
$server->run();