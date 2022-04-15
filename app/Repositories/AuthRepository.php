<?php

namespace App\Repositories;

use App\Models\User;
use App\Support\Generate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class AuthRepository
{
    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            $data['account_number'] = Generate::generateAccountNumber();

            return User::create($data);
        });
    }

    public function validateAuthenticate(array $data): User
    {
        if (Auth::validate($data))
        {
            return $this->getUserByCPF($data['cpf']);
        }

        throw new UnauthorizedException('Invalid Credentials');
    }

    public function getUserByCPF($cpf)
    {
        return User::where('cpf', $cpf)->first();
    }
}
