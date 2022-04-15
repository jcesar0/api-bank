<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private AuthRepository $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $payload = $request->validated();

        try {
            $user = $this->repository->register($payload);

            return new JsonResponse([
                'user' => $user
            ], 201);
        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], 422);
        }
    }
}
