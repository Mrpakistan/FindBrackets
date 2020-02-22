<?php


namespace App;

class FindBrackets
{
    private $str;

    public function __construct()
    {
        try {
            $this->checkStr();
            echo 'Всё хорошо';
        } catch (MyErrorHandler $e) {
            echo $e->getMessage();
        }
    }

    public function checkStr()
    {

        $this->str = $this->getStr();
        $left_b = substr_count($this->str, '(');
        $right_b = substr_count($this->str, ')');
        if (preg_match_all('#^[^(]+|[^\s()]+|[^)]+$#', $this->str, $matches)) {
            switch (true) {
                case stristr($matches[0][0], '('):
                    throw new MyErrorHandler((new MyErrorHandler())->errorSymbol(
                        'Ваша строка не заканчивается на ) '), 500);
                    break;
                case stristr($matches[0][0], ')'):
                    throw new MyErrorHandler((new MyErrorHandler())->errorSymbol(
                        'Ваша строка не начинается с ( '), 500);
                    break;
                default:
                    throw new MyErrorHandler((new MyErrorHandler())->errorSymbol(
                        'у вас не допустимые символы: ' . $matches[0][0]), 500);
            }

        } else if ($left_b !== $right_b) {
            $brackets_less = $left_b < $right_b ? 0 : 1;
            if ($brackets_less !== 0) {
                $brackets_less = $left_b - $right_b;
                throw new MyErrorHandler((new MyErrorHandler())->errorBs(
                    'знаков ( больше на: ' . $brackets_less), 500);
            } else {
                $brackets_less = $right_b - $left_b;
                throw new MyErrorHandler((new MyErrorHandler())->errorBs(
                    'знаков ) больше на: ' . $brackets_less), 500);
            }
        }

    }

    public function getStr(): string
    {
        $str = null;
        while (!$str) {
            $str = readline("Введите данные: ");
        }
        return $str;
    }
}
