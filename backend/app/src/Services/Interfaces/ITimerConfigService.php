<?php

namespace App\Services\Interfaces;

use App\Models\TimerConfig;

interface ITimerConfigService
{
    public function resetForUser(int $userID): bool;
    public function getForUser(int $userID): TimerConfig;
    public function updateForUser(TimerConfig $timerConfig): bool;
}
