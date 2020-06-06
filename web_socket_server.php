<?php

use Ratchet\Server\IoServer;
use App\WebSocket\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';



$loop   = React\EventLoop\Factory::create();
$pusher = new App\WebSocket\Pusher;

// Listen for the web server to make a ZeroMQ push after an ajax request
$context = new React\ZMQ\Context($loop);
$pull = $context->getSocket(\ZMQ::SOCKET_PULL);


$pull->bind('tcp://0.0.0.0:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
$pull->on('message', array($pusher, 'onBlogEntry'));

// Set up our WebSocket server for clients wanting real-time updates
$webSock = new React\Socket\Server('0.0.0.0:8080', $loop); // Binding to 0.0.0.0 means remotes can connect
$webServer = new Ratchet\Server\IoServer(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new Ratchet\Wamp\WampServer(
                $pusher
            )
        )
    ),
    $webSock
);

$loop->run();
