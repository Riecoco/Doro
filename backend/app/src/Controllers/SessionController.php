<?php

namespace App\Controllers;

use App\Models\Session;
use App\Framework\Controller;
use App\Services\SessionService;
use App\Services\Interfaces\ISessionService;

class SessionController extends Controller
{
    private ISessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    public function create()
    {
        try {
            $session = $this->mapPostDataToClass(Session::class);
            if (empty($session->user_id) || empty($session->token)) {
                return $this->sendErrorResponse('User ID and token are required', 400);
            }
            $createdSession = $this->sessionService->create($session);
            return $this->sendSuccessResponse($createdSession, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }
}
