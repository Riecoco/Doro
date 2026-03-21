<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\TimerConfig;
use App\Repositories\Interfaces\ITimerConfigRepository;

class TimerConfigRepository extends Repository implements ITimerConfigRepository
{
    public function __construct()
    {
        parent::__construct(TimerConfig::class);
    }

    public function resetForUser(int $userID): bool
    {
        $sql = '
            UPDATE TimerConfigs
            SET focusDuration = DEFAULT,
                shortBreakDuration = DEFAULT,
                longBreakDuration = DEFAULT
            WHERE user_id = :userID';
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['userID' => $userID]);
    }

    public function getForUser(int $userID): TimerConfig
    {
        $sql = 'SELECT * FROM TimerConfigs WHERE user_id = :userID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userID' => $userID]);
        $result = $stmt->fetch();
        return new TimerConfig($result);
    }

    public function updateForUser(TimerConfig $timerConfig): bool
    {
        $sql = '
            UPDATE TimerConfigs
            SET focusDuration = :focusDuration,
                shortBreakDuration = :shortBreakDuration,
                longBreakDuration = :longBreakDuration
            WHERE user_id = :userID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindValue(':focusDuration', $timerConfig->focusDuration, \PDO::PARAM_INT);
        $stmt->bindValue(':shortBreakDuration', $timerConfig->shortBreakDuration, \PDO::PARAM_INT);
        $stmt->bindValue(':longBreakDuration', $timerConfig->longBreakDuration, \PDO::PARAM_INT);
        $stmt->bindValue(':userID', $timerConfig->userID, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
