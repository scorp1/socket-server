<?php
namespace Socket;

class SocketClient
{
    private $host = '';

    private $port = '';

    private $socket = null;

    private $connect = null;

    private $string = '';

    public function __construct($host,$port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Создание сокета
     */
    public function createSocket()
    {
        if (($this->socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) === false){
            throw new InvalidArgumentException("Не удалось создать сокет");
        }
    }

    /**
     * Подключение к серверному сокету
     */
    public function connectSocket()
    {
        if (($this->connect = socket_connect($this->socket,$this->host,$this->port)) === false){
            socket_strerror(socket_last_error());
            die("Соединение с сокетом не установленно!\n");

        }else{
            echo "Соединение с сокетом установленно.\n";
        }
    }

    /**
     * Сокет запрашивает строку состоящую из скобок
     * @return bool|string
     */
    public function requestString()
    {
        echo "\n Введите уравнение из скобок\n";
        return $this->string = fgets(STDIN,255);
    }

    /**
     * Пересылка данных сокету
     */
    public function writeSocket()
    {
        socket_write($this->socket,$this->string,strlen($this->string));
    }

    /**
     * Чтение данных из сокета
     */
    public function readSocket()
    {
        $output = socket_read($this->socket,2048);
        echo $output;
        socket_close($this->socket);
    }
}
