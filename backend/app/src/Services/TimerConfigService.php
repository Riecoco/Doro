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
    public function create(TimerConfig $config): TimerConfig
    {
        return $this->repository->create($config);
    }

    public function reset(TimerConfig $config): bool
    {
        return $this->repository->reset($config->timerConfigID);
    }

    /**
     * Summary of getAllByUserID
     * @param int $userID
     * @return TimerConfig[]
     */
    public function getAllByUserID(int $userID): array
    {
        return $this->repository->getAllByUserID($userID);
    }

    public function getById(int $timerConfigID): ?TimerConfig
    {
        return $this->repository->getById($timerConfigID);
    }

    public function update(TimerConfig $timerConfig): bool
    {
        return $this->repository->update($timerConfig);
    }
}