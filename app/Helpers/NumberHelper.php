<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class NumberHelper
{
    public static function getRandomNumber($digits = 6)
    {
        $chunks = collect(Arr::shuffle(range(1, 9)))->chunk($digits);

        return $chunks->first()->implode('');
    }
}
