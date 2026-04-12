<?php

namespace App\Controllers;

use App\Exceptions\ApplicationException;
use App\Models\Enums\Role;
use App\Framework\Controller;
use App\Services\Interfaces\IAuthService;
use App\Services\AuthService;
use App\Models\UserDTO;

class BaseController extends Controller
{
    private IAuthService $authService;
    public function __construct() {
        parent::__construct();
        $this->authService = new AuthService();
    }

    public function currentUser(): UserDTO|null
    {
        try {

            // Get token from Authorization header
            if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $this->sendErrorResponse('Authorization header is required', 401);
                return null;
            }

            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            $headerParts = explode(' ', $authHeader);
            if (count($headerParts) !== 2 || strtolower($headerParts[0]) !== 'bearer') {
                $this->sendErrorResponse('Invalid authorization header format', 401);
                return null;
            }
            $token = $headerParts[1];

            $user = $this->authService->getUserFromToken($token);

            if (!$user) {
                $this->sendErrorResponse('Invalid or expired token', 401);
                return null;
            }

            // Return user DTO
            $userDTO = new UserDTO($user);
            return $userDTO;
        } catch (\Exception $e) {
            $this->sendErrorResponse('Internal server error', 500);
            return null;
        }
    }

    public function authenticateUser(): ?UserDTO
    {
        return $this->currentUser() !== null ? $this->currentUser() : throw new ApplicationException('Authentication required');
    }

    public function authenticateAdmin(): bool
    {
        $user = $this->currentUser();
        return $user && $user->role === Role::Admin ? true : throw new ApplicationException('Admin privileges required');
    }
}