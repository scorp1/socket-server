<?php
use Socket\StartSocketClient;
use Symfony\Component\Yaml\Yaml;
require_once __DIR__ . '/../vendor/autoload.php';

$loader = Yaml::parseFile('cfg/config.yaml');

$host = $loader['host'];
$port = $loader['port'];

set_time_limit(0);

ob_implicit_flush();

$server = new StartSocketClient($host,$port);
$server->start();