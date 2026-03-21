<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;

interface ITaskRepository
{
    public function getAllTasks(int $userID): array;
    public function getTaskById(int $taskID): ?Task;
    public function createTask(Task $task): int;
    public function updateTask(Task $task): bool;
    public function deleteTask(int $taskID): bool;
}
