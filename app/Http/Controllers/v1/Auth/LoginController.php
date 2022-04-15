<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;

class LoginController extends Controller
{
    private AuthRepository $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(LoginRequest $request)
    {
        $payload = $request->validated();

        try {
            $user = $this->repository->validateAuthenticate($payload);
            $token = $user->createToken('Bearer ');
            return [
                'token' => $token->plainTextToken,
                'user' => $user
            ];

        } catch (UnauthorizedException $exception) {
            return new JsonResponse(['error' => ['message' => $exception->getMessage()]], 401);
        }

        dd(1);
    }
}
