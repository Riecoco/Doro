<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\TimerConfig;
use App\Repositories\Interfaces\ITimerConfigRepository;

class TimerConfigRepository extends Repository implements ITimerConfigRepository
{
    public function create(TimerConfig $config): TimerConfig
    {
        $sql = '
            INSERT INTO TimerConfigs (userID, shortBreakDuration, longBreakDuration, focusDuration)
            VALUES (:userID, :shortBreakDuration, :longBreakDuration, :focusDuration)';
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bindValue(':userID', $config->userID, \PDO::PARAM_INT);
            $stmt->bindValue(':shortBreakDuration', $config->shortBreakDuration, \PDO::PARAM_INT);
            $stmt->bindValue(':longBreakDuration', $config->longBreakDuration, \PDO::PARAM_INT);
            $stmt->bindValue(':focusDuration', $config->focusDuration, \PDO::PARAM_INT);
            $stmt->execute();
            $id = $this->getConnection()->lastInsertId();
            return $this->getById($id);
    }
    
    public function reset(int $timerConfigID): bool
    {
        $sql = '
            UPDATE TimerConfigs
            SET focusDuration = DEFAULT,
                shortBreakDuration = DEFAULT,
                longBreakDuration = DEFAULT
            WHERE timerConfigID = :timerConfigID';
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['timerConfigID' => $timerConfigID]);
    }

    /**
     * @param int $userID
     * @return TimerConfig[]
     */
    public function getAllByUserID(int $userID): array
    {
        $sql = 'SELECT * FROM TimerConfigs WHERE userID = :userID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userID' => $userID]);
        $result = $stmt->fetchAll();
        $timerConfigs = [];
        foreach ($result as $row) {
            $timerConfigs[] = new TimerConfig($row);
        }
        return $timerConfigs;
    }

    public function getById(int $timerConfigID): ?TimerConfig
    {
        $sql = 'SELECT * FROM TimerConfigs WHERE timerConfigID = :timerConfigID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['timerConfigID' => $timerConfigID]);
        $result = $stmt->fetch();
        return $result ? new TimerConfig($result) : null;
    }

    public function update(TimerConfig $timerConfig): bool
    {
        $sql = '
            UPDATE TimerConfigs
            SET focusDuration = :focusDuration,
                shortBreakDuration = :shortBreakDuration,
                longBreakDuration = :longBreakDuration
            WHERE timerConfigID = :timerConfigID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':focusDuration', $timerConfig->focusDuration, \PDO::PARAM_INT);
        $stmt->bindValue(':shortBreakDuration', $timerConfig->shortBreakDuration, \PDO::PARAM_INT);
        $stmt->bindValue(':longBreakDuration', $timerConfig->longBreakDuration, \PDO::PARAM_INT);
        $stmt->bindValue(':timerConfigID', $timerConfig->timerConfigID, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}