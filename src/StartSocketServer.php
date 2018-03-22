<?php
namespace Socket;

use Socket\SocketServer;
use Socket\CheckBracketsInSocket;

class StartSocketServer
{
    /**
     * @var string
     */
    public $host = '';

    /**
     * @var string
     */
    public $port = '';

    /**
     * StartSocketServer constructor.
     *
     * @param $host
     * @param $port
     */
    public function __construct($host,$port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * start socket-server
     */
    public function start()
    {
        $newSocketServer = new SocketServer($this->host,$this->port);

        $newSocketServer->createSocket();

        $newSocketServer->bindSocket();

        $newSocketServer->listenSocket();

        $newSocketServer->readSocket();

        $newSocketServer->acceptSocket();

    }
}