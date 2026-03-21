<?php

namespace App\Repositories\Interfaces;

use App\Models\Enums\Type;
use App\Models\TimerConfig;

interface ITimerConfigRepository
{
    public function resetForUser(int $userID): bool;
    public function getForUser(int $userID): TimerConfig;
    public function updateForUser(TimerConfig $timerConfig): bool;
}
