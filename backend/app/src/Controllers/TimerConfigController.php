<?php

namespace App\Controllers;

use App\Models\TimerConfig;
use App\Framework\Controller;
use App\Services\TimerConfigService;
use App\Services\Interfaces\ITimerConfigService;

class TimerConfigController extends Controller
{
    private ITimerConfigService $timerConfigService;

    public function __construct()
    {
        $this->timerConfigService = new TimerConfigService();
    }

    public function reset()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $this->sendErrorResponse('Unauthorized', 401);
        }
        try {
            $result = $this->timerConfigService->resetForUser($userId);
            if ($result) {
                return $this->sendSuccessResponse(['message' => 'Timer configuration reset successfully']);
            } else {
                return $this->sendErrorResponse('Failed to reset timer configuration', 500);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function get()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $this->sendErrorResponse('Unauthorized', 401);
        }
        try {
            $config = $this->timerConfigService->getForUser($userId);
            if ($config) {
                return $this->sendSuccessResponse($config);
            } else {
                return $this->sendErrorResponse('Timer configuration not found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function update()
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return $this->sendErrorResponse('Unauthorized', 401);
        }
        try {
            $config = $this->mapPostDataToClass(TimerConfig::class);
            $config->userID = $userId;
            $updatedConfig = $this->timerConfigService->updateForUser($config);
            if ($updatedConfig) {
                return $this->sendSuccessResponse($updatedConfig);
            } else {
                return $this->sendErrorResponse('Failed to update timer configuration', 500);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }
}
