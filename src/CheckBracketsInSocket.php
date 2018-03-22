<?php
namespace Socket;

use Beloplotov\Balance;
use Socket\Exceptions\MyErrorException;

class CheckBracketsInSocket
{
    /** Method checking Brackets in Socket Server
     *
     * @return string
     */
    public function checkingBrackets($input)
    {

        try {
            $string = trim($input);
            $checkBalanceBrackets = new \Beloplotov\Balance();
            if ($checkBalanceBrackets->balanceBrackets($string)['message'] == 'Недопустимые символы') {
                throw new MyErrorException("Недопустимые симовлы");
            }
            if ($checkBalanceBrackets->balanceBrackets($string) !== true) {
                throw new MyErrorException("Ошибка ! Скобки стоят не верно!");
            }
            $output = "Все хорошо! Скобки стоят правильно";
        } catch (MyErrorException $e) {

            return $output = $e->getMessage();
        }

        return $output;
    }
}