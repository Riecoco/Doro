<?php

namespace App\Repositories\Interfaces;

use App\Models\Enums\Type;
use App\Models\TimerConfig;

interface ITimerConfigRepository
{
    public function create(TimerConfig $timerConfig): TimerConfig;
    public function reset(int $timerConfigID): bool;
    public function getAllByUserID(int $userID): array;
    public function getById(int $timerConfigID): ?TimerConfig;
    public function update(TimerConfig $timerConfig): bool;
}