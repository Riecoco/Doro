<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Session;
use App\Models\TimerConfig;
use App\Repositories\Interfaces\ISessionRepository;

class SessionRepository extends Repository implements ISessionRepository
{
    public function create(Session $session): Session
    {
        $sql = "INSERT INTO Sessions (taskID, startTime, endTime, isCompleted) VALUES (:taskID, :startTime, :endTime, :isCompleted)";
        $params = [
            ':taskID' => $session->taskID,
            ':startTime' => $session->startTime->format('Y-m-d H:i:s'),
            ':endTime' => $session->endTime->format('Y-m-d H:i:s'),
            ':isCompleted' => $session->isCompleted,
        ];
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute($params);
        $session->sessionID = (int)$this->getConnection()->lastInsertId();
        return $this->getById($session->sessionID);
    }

    private function getById(int $sessionID): ?Session
    {
        $sql = "SELECT * FROM Sessions WHERE sessionID = :sessionID";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['sessionID' => $sessionID]);
        $result = $stmt->fetch();
        return $result ? new Session($result) : null;
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
