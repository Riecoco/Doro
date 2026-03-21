<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Session;
use App\Models\TimerConfig;
use App\Repositories\Interfaces\ISessionRepository;

class SessionRepository extends Repository implements ISessionRepository
{
    public function createSession(Session $session): int
    {
        $sql = "INSERT INTO sessions (taskID, startTime, endTime, isCompleted) VALUES (:taskID, :startTime, :endTime, :isCompleted)";
        $params = [
            ':taskID' => $session->taskID,
            ':startTime' => $session->startTime->format('Y-m-d H:i:s'),
            ':endTime' => $session->endTime->format('Y-m-d H:i:s'),
            ':isCompleted' => $session->isCompleted,
        ];
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $this->getConnection()->lastInsertId();
    }

    // public function deleteSession(int $sessionID): bool
    // {
    //     $sql = "DELETE FROM sessions WHERE sessionID = :sessionID";
    //     $params = [':sessionID' => $sessionID];
    //     $stmt = $this->getConnection()->prepare($sql);
    //     $stmt->execute($params);
    //     return $stmt->rowCount() > 0;
    // }
}
