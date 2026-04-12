<?php

namespace App\Controllers;

use App\Models\TimerConfig;
use App\Framework\Controller;
use App\Services\TimerConfigService;
use App\Services\Interfaces\ITimerConfigService;

class TimerConfigController extends BaseController
{
    private ITimerConfigService $timerConfigService;

    public function __construct()
    {
        parent::__construct();
        $this->timerConfigService = new TimerConfigService();
    }

    public function create()
    {
        $user = $this->authenticateUser();
        try {
            $config = $this->mapPostDataToClass(TimerConfig::class);
            $config->userID = $user->id;
            $createdConfig = $this->timerConfigService->create($config);
            return $this->sendSuccessResponse($createdConfig, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }

    public function get($vars=[])
    {
        $user = $this->authenticateUser();
        try {
            $config = $this->timerConfigService->getById($vars['id']);
            if ($config) {
                return $this->sendSuccessResponse($config);
            } else {
                return $this->sendErrorResponse('Timer configuration not found', 404);
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }
    
    public function getAll()
    {
        $user = $this->authenticateUser();
        try {
            $configs = $this->timerConfigService->getAllByUserID($user->id);
            return $this->sendSuccessResponse($configs);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }


    public function update()
    {
        $user = $this->authenticateUser();
        try {
            $config = $this->mapPostDataToClass(TimerConfig::class);
            if (isset($config->timerConfigID)) {
                if (isset($_POST['reset']) && $_POST['reset'] === 'true') {
                    $result = $this->timerConfigService->reset($config);
                    return $result
                        ? $this->sendSuccessResponse(['message' => 'Timer configuration reset successfully'])
                        : $this->sendErrorResponse('Failed to reset timer configuration', 500);
                }

                $updatedConfig = $this->timerConfigService->update($config);
                return $updatedConfig
                    ? $this->sendSuccessResponse(['message' => 'Timer configuration updated successfully'])
                    : $this->sendErrorResponse('Failed to update timer configuration', 500);
            } else {
                return $this->create();
            }
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Oops, something went wrong!', 500);
        }
    }
}