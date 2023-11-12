<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use Exception;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {

    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            $userData = $this->userService->createUser($request->validated());

            return response()->json([
                'message' => 'User registered!',
                'data' => $userData,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listUsers()
    {
        try {
            $users = $this->userService->listAllUsers();

            return response()->json([
                'data' => $users,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
