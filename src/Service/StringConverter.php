<?php

declare(strict_types=1);

namespace App\Service;

class StringConverter
{
    public function convertString(string $string)
    {
        $string   = mb_strtolower($string, 'UTF-8');
        $string   = preg_replace('/[\-]+/', '-', $string);
        $string   = str_replace(' ', '-', $string);
        $string   = str_replace(['ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż'], ['a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z'], $string);
        $string   = trim($string, '-');

        return $string;
    }
}
