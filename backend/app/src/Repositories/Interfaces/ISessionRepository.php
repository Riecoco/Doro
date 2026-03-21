<?php

namespace App\Repositories\Interfaces;

use App\Models\Session;

interface ISessionRepository
{
    public function createSession(Session $session): int;
    //public function deleteSession(int $sessionID): bool;
}
