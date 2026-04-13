<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserDTO;
use App\Exceptions\UserAlreadyExistsException;
use App\Services\Interfaces\IAuthService;
use App\Services\AuthService;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    private IAuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }

    public function login()
    {
        try {
            $data = $this->getPostData();

            if (!isset($data['email']) || !isset($data['password'])) {
                return $this->sendErrorResponse('Email and password are required', 400);
            }

            // call the auth service to authenticate the user
            $user = $this->authService->authenticate($data['email'], $data['password']);

            if (!$user) {
                return $this->sendErrorResponse('Invalid credentials', 401);
            }

            // A DTO is used to return the user data to the client
            $userDTO = new UserDTO($user);
            $token = $this->authService->generateToken($user);

            return $this->sendSuccessResponse([
                'user' => $userDTO,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function register()
    {
        try {
            $user = $this->mapPostDataToClass(User::class);

            // basic, partial validation for demo/testing
            if (empty($user->email) || empty($user->password) || empty($user->username)) {
                return $this->sendErrorResponse('Email, username, and password are required', 400);
            }

            $user = $this->authService->register($user);

            // Return user data (excluding password for security)
            // DTOs (data transfer objects) are preferred when returning data to the client
            $userDTO = new UserDTO($user);
            return $this->sendSuccessResponse($userDTO, 201);
        } catch (UserAlreadyExistsException $e) {
            return $this->sendErrorResponse($e->getMessage(), 409); // 409: Conflict
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function loggedInUser()
    {
        $userDTO = parent::currentUser();
        
        if (!$userDTO) {
            return; // Error response already sent by parent
        }

        return $this->sendSuccessResponse($userDTO);
    }
}