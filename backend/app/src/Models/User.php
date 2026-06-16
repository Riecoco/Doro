<?php

namespace App\Models;

use App\Framework\Model;
use App\Models\Enums\Role;
use App\Framework\Annotations\Email;
use App\Framework\Annotations\Required;

class User extends Model
{
    public ?int $userID;
    #[Required]
    public string $username;
    #[Required]
    public Role $role;
    #[Email] #[Required]
    public string $email;
    #[Required]
    public string $password;
    public ?string $spotifyAccessToken;
    public ?string $bgPath;

    public function __construct(array $data = [])
    {
        $this->userID = $data['userID'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->role = isset($data['role'])
            ? Role::tryFrom($data['role'])
            : Role::User;
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->spotifyAccessToken = $data['spotifyAccessToken'] ?? null;
        $this->bgPath = $data['bgPath'] ?? null;
    }
}
