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
$clients = array($socket);
$msg = "Check your Brackets:\n\r";

do {

    $read = $clients;
// выбираем массив сокетов
    if (socket_select($read, $write = NULL, $except = NULL, 0) < 1)
        continue;

    if (in_array($socket, $read)) {
        // accept the client, and add him to the $clients array
        $clients[] = $newSocket = socket_accept($socket);
        socket_write($newSocket, $msg, strlen($msg));
        $key = array_search($socket, $read);
        unset($read[$key]);
    }

    foreach ($read as $read_sock) {
        $data = @socket_read($read_sock, 2048, PHP_NORMAL_READ);
        if ($data === false) {
            // remove client for $clients array
            $key = array_search($read_sock, $clients);
            unset($clients[$key]);
            echo "client disconnected.\n";
            // continue to the next client to read from, if any
            continue;
        }


        $data = trim($data);
        if ($data == 'quit') {
            $key = array_search($read_sock, $clients);
            socket_close($read_sock);
            unset($clients[$key]);
            echo "client disconnected.\n";
            continue;
        }
        if ($data == '') {
            continue;
        }
        if ($data === false) {
            break;
        }
        if (!$brackets->check($data)['status']) {
            socket_write($read_sock, $brackets->check($data)['msg']);
            continue;
        }
        $talkBack = sprintf("\n\r %s \n\r", $brackets->check($data)['msg']);
        socket_write($read_sock, $talkBack, strlen($talkBack));
        print sprintf(": %s\n\r", $data);
    }
} while (true);
// закрываем socket_create
socket_close($socket);


/*do {
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
socket_close($socket);*/
