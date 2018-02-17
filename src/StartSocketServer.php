<?php
namespace Socket;
use Socket\SocketServer;

class StartSocketServer
{
    public $host = '';
    public $port = '';
    public function __construct($host,$port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function start()
    {
        $NewSocketServer = new SocketServer($this->host,$this->port);

        $NewSocketServer->createSocket();
        $NewSocketServer->bindSocket();
        $NewSocketServer->listenSocket();
        $NewSocketServer->readSocket();
        $NewSocketServer->acceptSocket();

    }
}