<?php
use Socket\StartSocketServer;

require_once __DIR__ . '/../vendor/autoload.php';

$shortopts = "p:";
$longopts = array("port:","host:");

$options = getopt($shortopts,$longopts);
if(!isset($options['port']))
{
    die("Нужно указать параметры host (не обязательный параметр) и port!\n Например:   php server.php --host 127.0.0.1 --port 8080\n");
}
if(!isset($options['host']))
{
    $options['host'] = '127.0.0.1';
}
$host = $options['host'];
$port = $options['port'];

set_time_limit(0);

ob_implicit_flush();

$server = new StartSocketServer($host,$port);
$server->start();