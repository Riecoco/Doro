<?php

namespace App\Services\Interfaces;

use App\Models\Task;
use App\Models\UpdateTaskDTO;

interface ITaskService
{
    public function getAllByStatusForUser(int $userID, bool $isCompleted): array;
    public function getById(int $taskID): ?Task;
    public function create(Task $task): Task;
    public function update(UpdateTaskDTO $task): ?Task;
    public function delete(int $taskID): bool;
}
