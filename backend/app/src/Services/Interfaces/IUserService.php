<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface IUserService
{
    public function getById(int $id): ?User;
    public function getByEmail(string $email): ?User;
    public function create(User $user): User;
    public function update(User $user): bool;
}
