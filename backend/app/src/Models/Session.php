<?php

namespace App\Models;

use App\Framework\Model;
use App\Framework\Annotations\Required;

use DateTime;

class Session extends Model
{
    public ?int $sessionID;
    #[Required]
    public int $taskID;
    #[Required]
    public TimerConfig $timerConfig;
    #[Required]
    public DateTime $startTime;
    public ?DateTime $endTime;
    #[Required]
    public bool $isCompleted;

    public function __construct(array $data = [])
    {
        $this->sessionID = $data['sessionID'] ?? null;
        $this->taskID = $data['taskID'] ?? 0;
        $this->timerConfig = $data['timerConfigID'] ? new TimerConfig($data) : new TimerConfig();
        $this->startTime = isset($data['startTime']) ? new DateTime($data['startTime']) : new DateTime();
        $this->endTime = isset($data['endTime']) ? new DateTime($data['endTime']) : null;
        $this->isCompleted = $data['isCompleted'] ?? false;
    }
}
