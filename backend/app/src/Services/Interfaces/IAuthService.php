<?php

namespace App\Services;

use App\Models\User;

interface IAuthService
{
    public function authenticate(string $email, string $password): ?User;
    public function register(User $user): User;
    public function getUserFromToken(string $token): ?User;
    public function generateToken(User $user): string;
    public function validateToken(string $token): bool;
}
