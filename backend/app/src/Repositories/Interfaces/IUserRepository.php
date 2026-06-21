<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function getById(int $userID): ?User;
    public function getByEmail(string $email): ?User;
    public function create(User $user): User;
    public function update(User $user): bool;
}
