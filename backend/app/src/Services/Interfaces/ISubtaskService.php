<?php

namespace App\Services\Interfaces;

use App\Models\Subtask;

interface ISubtaskService
{
    public function create(Subtask $subtask): Subtask;
    public function update(Subtask $subtask): bool;
    public function delete(int $subtaskID): bool;
}
