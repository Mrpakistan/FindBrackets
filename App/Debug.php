<?php


namespace App;

// debug func
class Debug
{
    public static function debug($arr): void
    {
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }
}
