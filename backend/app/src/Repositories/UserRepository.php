<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository extends Repository implements IUserRepository
{
    public function getById(int $userID): ?User
    {
        $sql = 'SELECT * FROM Users
                WHERE userID = :userID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userID' => $userID]);
        $result = $stmt->fetch();
        return $result ? new User($result) : null;
    }

    public function getByEmail(string $email): ?User
    {
        $sql = 'SELECT * FROM Users
                WHERE email = :email';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ? new User($result) : null;
    }

    public function create(User $user): User
    {
        $userSql = '
            INSERT INTO Users (username, email, password, role)
            VALUES (:username, :email, :password, :role)';
        $stmt = $this->getConnection()->prepare($userSql);
        $stmt->bindValue(':username', $user->username, \PDO::PARAM_STR);
        $stmt->bindValue(':email', $user->email, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->password, \PDO::PARAM_STR);
        $stmt->bindValue(':role', $user->role->value, \PDO::PARAM_STR);
        $stmt->execute();
        $userID = (int)$this->getConnection()->lastInsertId();
        return $this->getById($userID);
    }

    public function update(User $user): bool
    {
        $sql = 'UPDATE Users
                SET email = :email,
                    password = :password,
                    username = :username
                WHERE userID = :userID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':email', $user->email, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $user->password, \PDO::PARAM_STR);
        $stmt->bindValue(':username', $user->username, \PDO::PARAM_STR);
        $stmt->bindValue(':userID', $user->userID, \PDO::PARAM_INT);

        return $stmt->execute();
    }
}