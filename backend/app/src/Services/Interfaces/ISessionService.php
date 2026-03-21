<?php

namespace App\Services\Interfaces;

use App\Models\Session;

interface ISessionService
{
    public function create(Session $session): Session;
    //public function delete(int $sessionID): bool;
}
