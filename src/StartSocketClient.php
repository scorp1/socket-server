<?php
namespace Socket;
use Socket\SocketClient;
//require_once __DIR__ . '/SocketClient.php';

class StartSocketClient
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
        $NewClientSocket = new SocketClient($this->host,$this->port);

        $NewClientSocket->createSocket();
        $NewClientSocket->connectSocket();
        $NewClientSocket->requestString();
        $NewClientSocket->writeSocket();
        $NewClientSocket->readSocket();
    }
}