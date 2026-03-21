<?php

namespace App\Services;

use App\Models\TimerConfig;
use App\Repositories\TimerConfigRepository;
use App\Repositories\Interfaces\ITimerConfigRepository;
use App\Services\Interfaces\ITimerConfigService;

class TimerConfigService implements ITimerConfigService
{
    private ITimerConfigRepository $repository;

    public function __construct()
    {
        $this->repository = new TimerConfigRepository();
    }

    public function resetForUser(int $userID): bool
    {
        return $this->repository->resetForUser($userID);
    }

    public function getForUser(int $userID): TimerConfig
    {
        return $this->repository->getForUser($userID);
    }

    public function updateForUser(TimerConfig $timerConfig): bool
    {
        return $this->repository->updateForUser($timerConfig);
    }
}
