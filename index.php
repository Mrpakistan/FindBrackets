<?php

use App\FindBrackets;

require_once 'App/FindBrackets.php';
require_once 'App/MyErrorHandler.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') die('Войдите из консоли!!!!!');


$test = new FindBrackets();
