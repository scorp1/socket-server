<?php
namespace Socket;

use Socket\SocketClient;

class StartSocketClient
{
    /**
     * ip address socket-client
     *
     * @var string
     */
    public $host = '';

    /**
     * number port socket-client
     *
     * @var int
     */
    public $port = '';

    /**
     * StartSocketClient constructor.
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($host,$port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * start socket-client
     */
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