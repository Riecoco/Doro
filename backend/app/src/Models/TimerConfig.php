<?php

namespace App\Models;

use App\Framework\Annotations\Required;
use App\Framework\Model;

class TimerConfig extends Model
{
    public ?int $timerConfigID;
    #[Required]
    public int $userID;
    #[Required]
    public int $focusDuration;
    #[Required]
    public int $shortBreakDuration;
    #[Required]
    public int $longBreakDuration;

    public function __construct(array $data = [])
    {
        $this->timerConfigID = $data['timerConfigID'] ?? null;
        $this->userID = $data['userID'] ?? null;
        $this->focusDuration = $data['focusDuration'] ?? 25;
        $this->shortBreakDuration = $data['shortBreakDuration'] ?? 5;
        $this->longBreakDuration = $data['longBreakDuration'] ?? 15;
    }
}
