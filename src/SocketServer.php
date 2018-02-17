<?php
namespace Socket;

use Beloplotov\Balance;
use Symfony\Component\Console\Exception\InvalidArgumentException;

class SocketServer
{
    private $host = '';

    private $port = '';

    private $socket = null;

    private $clients_socket = array();

    private $max_clients = 10;

    private $read = array();

    private $write = null;

    private $error = null;

    private $balance_brackets = null;

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
     * Привязка имени к сокету
     */
    public function bindSocket()
    {
        if ((socket_bind($this->socket,$this->host,$this->port)) === false){
            socket_strerror(socket_last_error($this->socket));
            die("Соединение Не установленно!\n");
        }else{
            echo "Соединение установленно \n";
        }
    }

    /**
     * Прослушивание входящих соединений на сервере
     */
    public function listenSocket()
    {
        if(socket_listen($this->socket) === false){
            throw new InvalidArgumentException(socket_strerror(socket_last_error($this->socket)));
        }else{
            echo "Слушаю порт $this->port \n";
        }
    }

    /**
     * Функция читает данные из сокета
     */
    public function readSocket()
    {
        $this->read = array($this->socket);
    }

    /**
     * Функция ожидает подключения чтобы прочитать сокет
     */
    public function selectSocket()
    {
        $num_changed = socket_select($this->read,$this->write,$this->error,0,10);
        if ($num_changed)
        {
            if (in_array($this->socket,$this->read))
            {

                if (count($this->clients_socket) < $this->max_clients)
                {
                    $this->clients_socket[] = socket_accept($this->socket);
                    echo "Accept connect (" . count($this->clients_socket) . "of $this->max_clients\n";
                }

            }
        }
    }

    /**
     * Функция принимает соединение на сокете выполняет функцию проверки скобок
     * И возвращает результат
     */

    public function acceptSocket()
    {
        while (true)
        {
            $this->selectSocket();

            foreach ($this->clients_socket as $key => $client)
            {

                if(in_array($client,$this->read))
                {
                    $input = socket_read($client,1024);

                    if ($input === false){
                        socket_shutdown($client);
                        unset($this->clients_socket[$key]);
                    }
                    else
                    {

                        $resultCheckingBrackets = $this->checkingBrackets($input);

                        if (!@socket_write($client,"Ответ: $resultCheckingBrackets\n" ))
                        {
                            socket_close($client);
                            unset($this->clients_socket[$key]);
                        }
                    }
                    if ($input === 'exit')
                    {
                        socket_shutdown($client);
                    }
                }
            }//END FOREACH
            $this->read = $this->clients_socket;
            $this->read[] = $this->socket;
        }//END WHILE
    }//END FUNCTION

    /**
     * Функции balanceBrackets проверка скобок
     */
    public function checkingBrackets($string)
    {

        try
        {
            $string = trim($string);
            $this->balance_brackets = new \Beloplotov\Balance();
            if($this->balance_brackets->balanceBrackets($string)['message'] == 'Недопустимые символы')
            {
                throw new \Exception("Недопустимые симовлы");
            }
            if($this->balance_brackets->balanceBrackets($string) !== true)
            {
                throw new \Exception("Ошибка ! Скобки стоят не верно!");
            }
            $output = "Все хорошо! Скобки стоят правильно";
        }catch (\Exception $e)
        {
            return $output = $e->getMessage();
        }
        return $output;
    }

}

