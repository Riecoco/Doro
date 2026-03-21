<?php

namespace App\Services;

use App\Models\Session;
use App\Repositories\Interfaces\ISessionRepository;
use App\Services\Interfaces\ISessionService;
use App\Repositories\SessionRepository;

class SessionService implements ISessionService
{
    private ISessionRepository $repository;

    public function __construct()
    {
        $this->repository = new SessionRepository();
    }

    public function create(Session $session): Session
    {
        return $this->repository->create($session);
    }

    //public function delete(int $sessionID): bool
    //{
    //    return $this->repository->delete($sessionID);
    //}
}
