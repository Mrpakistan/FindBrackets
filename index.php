<?php

use App\Brackets;

require_once 'App/MyErrorHandler.php';
require_once 'App/Brackets.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') die('Войдите из консоли!!!!!');

$brackets = new Brackets();

//для передачи порта в качестве аргумента )
$short_port = "";
$short_port .= "p: ";
$long_port = array(
    "p:",
);
//преобразует агрумент в массив
$options = getopt($short_port, $long_port);

$address = '192.168.1.187';
$main_port = $options['p'];
//создаем сокет
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
// захватываем сокет
socket_bind($socket, $address, $main_port);
// слушаем сокет
socket_listen($socket, 2);

do {
//    принимаем сокет
    $socket_msg = socket_accept($socket);
    $msg = "Check your Brackets:\n\r";
//    Пишим в сокет
    socket_write($socket_msg, $msg, strlen($msg));
    do {
//        читаем из сокета
        $buffer = socket_read($socket_msg, 2048, PHP_NORMAL_READ);
        $buffer = trim($buffer);
        if ($buffer == 'quit') {
            break;
        }
        if ($buffer == '') {
            continue;
        }
        if (!$brackets->check($buffer)['status']) {
            socket_write($socket_msg, $brackets->check($buffer)['msg']);
            continue;
        }
        $talkBack = sprintf("\n\r %s \n\r", $brackets->check($buffer)['msg']);
        socket_write($socket_msg, $talkBack, strlen($talkBack));
        print sprintf(": %s\n\r", $buffer);
    } while (true);
//    закрываем socket_accept
    socket_close($socket_msg);
} while (true);
// закрываем socket_create
socket_close($socket);
