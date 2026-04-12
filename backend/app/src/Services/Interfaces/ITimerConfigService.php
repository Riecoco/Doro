<?php

namespace App\Services\Interfaces;

use App\Models\TimerConfig;

interface ITimerConfigService
{
    public function create(TimerConfig $timerConfig): TimerConfig;
    public function reset(TimerConfig $timerConfig): bool;
    public function getAllByUserID(int $userID): array;
    public function getById(int $timerConfigID): ?TimerConfig;
    public function update(TimerConfig $timerConfig): bool;
}