<?php

namespace App\Models;

use App\Framework\Model;
use App\Models\Enums\Role;

class User extends Model
{
    public ?int $userID;
    public string $username;
    public Role $role;
    public string $email;
    public string $password;
    public ?string $spotifyAccessToken;
    public ?string $customBgImgFilepath;
    public ?string $customBgImgFilename;

    public function __construct(array $data = [])
    {
        $this->userID = $data['userID'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->role = $data['role'] ? Role::from($data['role']) : Role::User;
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->spotifyAccessToken = $data['spotifyAccessToken'] ?? null;
        $this->customBgImgFilepath = $data['customBgImgFilepath'] ?? null;
        $this->customBgImgFilename = $data['customBgImgFilename'] ?? null;
    }
}
