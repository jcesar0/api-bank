<?php

namespace App\Repositories;

use App\Models\User;
use App\Support\Generate;
use Illuminate\Support\Facades\DB;

class AuthRepository
{
    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['account_number'] = Generate::generateAccountNumber();

            return User::create($data);
        });
    }
}
