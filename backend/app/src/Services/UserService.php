<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\UserRepository;

class UserService implements IUserService
{
    private IUserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function getById(int $id): ?User
    {
        return $this->repository->getById($id);
    }

    public function getByEmail(string $email): ?User
    {
        return $this->repository->getByEmail($email);
    }

    public function create(User $user): User
    {
        return $this->repository->create($user);
    }

    public function update(User $user): bool
    {
        return $this->repository->update($user);
    }
}
