<?php
use Socket\StartSocketServer;
use Symfony\Component\Yaml\Yaml;
require_once __DIR__ . '/../vendor/autoload.php';

$parserPort = Yaml::parseFile('cfg/config.yaml');

$host = '127.0.0.1';
$port = $parserPort['port'];

set_time_limit(0);

ob_implicit_flush();

$server = new StartSocketServer($host,$port);
$server->start();