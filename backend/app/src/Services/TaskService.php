<?php

namespace App\Services;

use App\Models\Task;
use App\Models\UpdateTaskDTO;
use App\Repositories\Interfaces\ITaskRepository;
use App\Repositories\TaskRepository;
use App\Services\Interfaces\ITaskService;

class TaskService implements ITaskService
{
    private ITaskRepository $repository;

    public function __construct()
    {
        $this->repository = new TaskRepository();
    }
    public function create(Task $task): Task
    {
        return $this->repository->create($task);
    }

    public function getAllByStatusForUser(int $userID, bool $isCompleted): array
    {
        return $this->repository->getAllByStatusForUser($userID, $isCompleted);
    }

    public function getById(int $taskID): ?Task
    {
        return $this->repository->getById($taskID);
    }

    public function update(UpdateTaskDTO $task): ?Task
    {
        return $this->repository->update($task);
    }

    public function delete(int $taskID): bool
    {
        return $this->repository->delete($taskID);
    }
}