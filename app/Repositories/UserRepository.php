<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByAccountNumber($number)
    {
        return User::where('account_number', $number)->first();
    }
}
