<?php

namespace Socket;

use Beloplotov\Balance;
use Socket\CheckBracketsInSocket;
use Socket\Exceptions\MySocketException;
use Socket\Exceptions\MyErrorException;

class SocketServer
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
     * @var null
     */
    private $socket = null;

    /**
     * array of socket clients
     *
     * @var array
     */
    private $SocketClients = array();

    /**
     * max count clients
     *
     * @var int
     */
    private $maximumClientsSocket = 10;

    /**
     * socket reading
     *
     * @var array
     */
    private $readSocket = array();

    /**
     * write from a socket
     *
     * @var null
     */
    private $writeSocket = null;

    /**
     * error-catching variable
     *
     * @var null
     */
    private $errorSocket = null;

    /**
     * brackets checking variable
     *
     * @var null
     */
    private $CheckBalanceBrackets = null;

    /**
     * SocketServer constructor.
     *
     * @param string $host
     * @param int $port
     */
    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Create Socket-server
     */
    public function createSocket()
    {
        if (($this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            throw new MySocketException();
        }
    }

    /**
     * bind Socket-server
     */
    public function bindSocket()
    {
        if ((socket_bind($this->socket, $this->host, $this->port)) === false) {
            socket_strerror(socket_last_error($this->socket));
            die("Соединение Не установленно!\n");
        }
        echo "Соединение установленно \n";
    }

    /**
     * Listening for incoming connections on the server
     *
     * @throws MySocketException
     */
    public function listenSocket()
    {
        if (socket_listen($this->socket) === false) {
            throw new MySocketException(socket_strerror(socket_last_error($this->socket)));
        }
        echo "Слушаю порт $this->port \n";
    }

    /**
     * Reading data from the socket
     *
     */
    public function readSocket()
    {
        $this->readSocket = array($this->socket);
    }

    /**
     * waits for a socket connection connection
     */
    public function selectSocket()
    {
        $num_changed = socket_select($this->readSocket, $this->writeSocket, $this->errorSocket, 0, 10);
        if ($num_changed) {
            if (in_array($this->socket, $this->readSocket)) {

                if (count($this->SocketClients) < $this->maximumClientsSocket) {
                    $this->SocketClients[] = socket_accept($this->socket);

                    echo "Accept connect (" . count($this->SocketClients) . "of $this->maximumClientsSocket\n";
                }
            }
        }
    }

    /**
     * accepts the connection on the socket performs the function of checking parentheses and returns the result
     */
    public function acceptSocket()
    {
        while (true) {
            $this->selectSocket();

            foreach ($this->SocketClients as $key => $client) {

                if (in_array($client, $this->readSocket)) {
                    $input = socket_read($client, 1024);
                    if ($input === false) {
                        socket_shutdown($client);
                        unset($this->SocketClients[$key]);
                    }
                    $resultCheckingBrackets = new CheckBracketsInSocket();

                        if (!@socket_write($client, "Ответ: {$resultCheckingBrackets->checkingBrackets($input)}\n")) {
                            socket_close($client);
                            unset($this->SocketClients[$key]);
                        }
                    if ($input === 'exit') {
                        socket_shutdown($client);
                    }
                }
            }//END FOREACH
            $this->readSocket = $this->SocketClients;
            $this->readSocket[] = $this->socket;
        }//END WHILE
    }//END FUNCTION
}

