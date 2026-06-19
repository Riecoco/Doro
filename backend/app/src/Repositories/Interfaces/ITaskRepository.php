<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use App\Models\UpdateTaskDTO;

interface ITaskRepository
{
    public function getAllByStatusForUser(int $userID, bool $isCompleted): array;
    public function getById(int $taskID): ?Task;
    public function create(Task $task): Task;
    public function update(UpdateTaskDTO $dto): ?Task;
    public function delete(int $taskID): bool;
}
