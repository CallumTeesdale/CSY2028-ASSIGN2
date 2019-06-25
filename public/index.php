<?php
require '../functions/autoload.php';
session_start();
$routes = new \frans\Routes();
$entryPoint = new \classes\EntryPoint($routes);
$entryPoint->run();
