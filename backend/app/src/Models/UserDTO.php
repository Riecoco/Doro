<?php

namespace App\Models;

use App\Models\Enums\Role;

class UserDTO
{
    public int $id;
    public string $username;
    public string $email;
    public Role $role;

    public function __construct(User $user)
    {
        $this->id = $user->userID;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role->value
        ];
    }
}
