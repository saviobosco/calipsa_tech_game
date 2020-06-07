<?php


namespace App\WebSocket;


class EventPusher
{
    public static function pushEvent($details)
    {
        // This is our new stuff
        $context = new \ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
        $socket->connect("tcp://0.0.0.0:5555");

        $socket->send(json_encode($details));
    }

}
