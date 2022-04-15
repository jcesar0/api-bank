<?php

namespace App\Support;

use App\Repositories\UserRepository;
use Illuminate\Support\Str;

class Generate
{
    public static function generateAccountNumber(): string
    {
        $min = 1000000000;
        $max = 9999999999;

        $userRepository = new UserRepository();

        do {
            $number = random_int($min, $max);
        } while ($userRepository->findByAccountNumber($number));

        return $number;
    }
}
