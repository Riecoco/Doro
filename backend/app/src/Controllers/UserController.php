<?php

namespace App\Controllers;

use App\Models\User;
use App\Framework\Controller;
use App\Services\UserService;
use App\Services\Interfaces\IUserService;

class UserController extends Controller
{
    private IUserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function getById($id)
    {
        try {
            $user = $this->userService->getById($id);
            if (!$user) {
                return $this->sendErrorResponse('User not found', 404);
            }
            return $this->sendSuccessResponse($user);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function update($id)
    {
        try {
            $user = $this->mapPostDataToClass(User::class);
            $user->id = $id;
            if (empty($user->username) || empty($user->email)) {
                return $this->sendErrorResponse('Username and email are required', 400);
            }
            $updated = $this->userService->update($user);
            if (!$updated) {
                return $this->sendErrorResponse('User not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }
}
