<?php

namespace App\Models;

use App\Framework\Model;

use DateTime;

class Session extends Model
{
    public ?int $sessionID;
    public int $taskID;
    public TimerConfig $timerConfig;
    public DateTime $startTime;
    public DateTime $endTime;
    public bool $isCompleted;

    public function __construct(array $data = [])
    {
        $this->sessionID = $data['sessionID'] ?? null;
        $this->taskID = $data['taskID'] ?? 0;
        $this->timerConfig = $data['timerConfigID'] ? new TimerConfig($data) : new TimerConfig();
        $this->startTime = isset($data['startTime']) ? new DateTime($data['startTime']) : new DateTime();
        $this->endTime = isset($data['endTime']) ? new DateTime($data['endTime']) : new DateTime();
        $this->isCompleted = $data['isCompleted'] ?? false;
    }
}
