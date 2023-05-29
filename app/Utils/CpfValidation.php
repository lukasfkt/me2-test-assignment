<?php

namespace App\Utils;

class CpfValidation
{

    /**
     * Validate CPF input
     * 
     * @param string attribute
     * @param string value
     *
     * @author Lucas Tanaka
     * @return bool true if cpf is valid or false if invalid
     */

    public function validate(string $attribute, string $value)
    {
        $c = preg_replace('/\D/', '', $value);
        if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
            return false;
        }
        for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
        if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
        if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }
        return true;
    }
}
