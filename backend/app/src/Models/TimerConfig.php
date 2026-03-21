<?php

namespace App\Models;

use App\Models\Enums\Type;
use App\Framework\Model;

class TimerConfig extends Model
{
    public ?int $timerConfigID;
    public int $userID;
    public int $focusDuration;
    public int $shortBreakDuration;
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
