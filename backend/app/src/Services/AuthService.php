<?php

namespace App\Services;

use App\Models\User;
use App\Exceptions\UserAlreadyExistsException;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\UserRepository;
use App\Services\Interfaces\IAuthService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Config;

class AuthService implements IAuthService
{
    private const JWT_ALGORITHM = 'HS256';

    private IUserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->userRepository->getByEmail($email);

        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user->password)) {
            return null;
        }

        return $user;
    }

    public function generateToken(User $user): string
    {
        $now = time();
        $expiration = $now + (Config::$tokenExpirationHours * 3600); // Convert hours to seconds

        $payload = [
            'iss' => Config::$domain, // Issuer
            'aud' => Config::$domain, // Audience
            'iat' => $now, // Issued at
            'nbf' => $now, // Not before
            'exp' => $expiration, // Expiration time (24 hours from now)
            'data' => [
                'id' => $user->userID,
                'email' => $user->email,
                'username' => $user->username
            ],
        ];

        return JWT::encode($payload, Config::$secretKey, self::JWT_ALGORITHM);
    }

    public function validateToken(string $token): bool
    {
        try {
            $decoded = JWT::decode($token, new Key(Config::$secretKey, self::JWT_ALGORITHM));

            if (!isset($decoded->iss) || !isset($decoded->aud) || !isset($decoded->exp)) {
                return false;
            }

            if ($decoded->iss !== Config::$domain || $decoded->aud !== Config::$domain) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getUserFromToken(string $token): ?User
    {
        try {
            $decoded = JWT::decode($token, new Key(Config::$secretKey, self::JWT_ALGORITHM));
        } catch (\Exception $e) {
            return null; 
        }

        if (isset($decoded->data->id)) {
            return $this->userRepository->getById($decoded->data->id);
        }

        return null;
    }

    public function register(User $user): User
    {
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        $existingUser = $this->userRepository->getByEmail($user->email);
        if ($existingUser) {
            throw new UserAlreadyExistsException();
        }

        return $this->userRepository->create($user);
    }
}
