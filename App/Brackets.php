<?php


namespace App;


class Brackets
{
    public function check($string)
    {
        $left_b = substr_count($string, '(');
        $right_b = substr_count($string, ')');
        $msg = [
            'msg' => 'it\'s ok!' . "\n\r",
            'status' => true
        ];
        if (preg_match_all('#^[^(]+|[^\s\n\r()]+|[^)]+$#', $string, $matches)) {
            switch (true) {
                case stristr($matches[0][0], '('):
                    $msg = [
                        'msg' => 'string need ending ) ' . "\n\r",
                        'status' => false
                    ];
                    break;
                case stristr($matches[0][0], ')'):
                    $msg = [
                        'msg' => 'string need begin ( ' . "\n\r",
                        'status' => false
                    ];
                    break;
                default:
                    $msg = [
                        'msg' => 'wrong symbol: ' . $matches[0][0] . "\n\r",
                        'status' => false
                    ];

            }

        } else if ($left_b !== $right_b) {
            $brackets_less = $left_b < $right_b ? 0 : 1;
            if ($brackets_less !== 0) {
                $brackets_less = $left_b - $right_b;
                $msg = [
                    'msg' => '( more: ' . $brackets_less . "\n\r",
                    'status' => false
                ];
            } else {
                $brackets_less = $right_b - $left_b;
                $msg = [
                    'msg' => ' ) more: ' . $brackets_less . "\n\r",
                    'status' => false
                ];

            }
        }
        return $msg;
    }
}
