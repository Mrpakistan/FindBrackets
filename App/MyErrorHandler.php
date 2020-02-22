<?php


namespace App;


use Exception;


class MyErrorHandler extends Exception
{
    private $file_path;
    private $str;
    public $symbol;


    public function errorFile($msg)
    {
        return $this->file_path = $msg;

    }

    public function errorBs($msg)
    {
        return $this->str = $msg;
    }

    public function errorSymbol($msg)
    {
        return $this->symbol = $msg;
    }


}



