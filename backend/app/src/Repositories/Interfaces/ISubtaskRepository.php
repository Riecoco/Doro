<?php

namespace App\Repositories\Interfaces;

use App\Models\Subtask;

interface ISubtaskRepository
{
    public function createSubtask(Subtask $subtask): int;
    public function updateSubtask(Subtask $subtask): bool;
    public function deleteSubtask(int $subtaskID): bool;
}
