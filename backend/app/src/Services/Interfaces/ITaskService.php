<?php

namespace App\Services\Interfaces;

use App\Models\Task;

interface ITaskService
{
    public function getAll(int $userID): array;
    public function getById(int $taskID): ?Task;
    public function create(Task $task): Task;
    public function update(Task $task): bool;
    public function delete(int $taskID): bool;
}
