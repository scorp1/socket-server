<?php
namespace Socket;

use Socket\Exceptions\MySocketException;

class SocketClient
{
    /**
     * ip address socket-server
     *
     * @var string
     */
    private $host = '';

    /**
     * number port socket-server
     *
     * @var int
     */
    private $port = '';

    /**
     * socket_create variable
     *
     * @var resource
     */
    private $socket = null;

    /**
     * socket_connect variable
     *
     * @var bool
     */
    private $connectSocket = null;

    /**
     * variable for writing data
     *
     * @var string
     */
    private $stringWithEquation = '';

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Create socket-client connection
     *
     * @throws MySocketException
     */
    public function createSocket()
    {
        if (($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            throw new MySocketException();
        }
    }

    /**
     * Connecting to a server socket
     */
    public function connectSocket()
    {
        if (($this->connectSocket = socket_connect($this->socket, $this->host, $this->port)) === false) {
            socket_strerror(socket_last_error());

            die("Соединение с сокетом не установленно!\n");

        }
        echo "Соединение с сокетом установленно.\n";
    }

    /**
     * query string
     *
     * @return bool|string
     */
    public function requestString()
    {
        echo "\n Введите уравнение из скобок\n";

        return $this->stringWithEquation = fgets(STDIN, 255);
    }

    /**
     * sends a string to the server
     */
    public function writeSocket()
    {
        socket_write($this->socket, $this->stringWithEquation, strlen($this->stringWithEquation));
    }

    /**
     * Read response from server
     */
    public function readSocket()
    {
        $output = socket_read($this->socket, 2048);

        echo $output;
        socket_close($this->socket);
    }
}