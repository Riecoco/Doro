<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Task;
use App\Models\Session;
use App\Models\Subtask;
use App\Repositories\Interfaces\ITaskRepository;

class TaskRepository extends Repository implements ITaskRepository
{
    /**
     * @return Task[]
     */
    public function getAll(int $userID): array
    {
        $sql = "
            SELECT T.taskID, T.userID, T.title, T.description, T.isCompleted
            FROM Tasks as T
            WHERE T.userID = :userID AND T.isCompleted = 0";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userID' => $userID]);
        $tasks = [];
        $results = $stmt->fetchAll();
        foreach ($results as $result) {
            $tasks[] = new Task($result);
        }
        return $tasks;
    }

    public function getById(int $taskID): ?Task
    {
        $sql = "
            SELECT * FROM Tasks 
            WHERE taskID = :taskID";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['taskID' => $taskID]);
        $data = $stmt->fetch();
        return $data ? new Task($data) : null;
    }

    public function create(Task $task): Task
    {
        $sql = "
            INSERT INTO Tasks (userID, title, description, isCompleted, estimatedCycles) 
            VALUES (:userID, :title, :description, :isCompleted, :estimatedCycles)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            'userID' => $task->user?->userID,
            'title' => $task->title,
            'description' => $task->description,
            'isCompleted' => (int)$task->isCompleted
        ]);
        $taskID = (int)$this->getConnection()->lastInsertId();
        return $this->getById($taskID);
    }

    public function update(Task $task): bool
    {
        $sql = "UPDATE Tasks 
                SET title = :title, description = :description, isCompleted = :isCompleted, estimatedCycles = :estimatedCycles
                WHERE taskID = :taskID";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([
            'taskID' => $task->taskID,
            'title' => $task->title,
            'description' => $task->description,
            'isCompleted' => (int)$task->isCompleted
        ]);
    }

    public function delete(int $taskID): bool
    {
        $sql = "DELETE FROM Tasks WHERE taskID = :taskID";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['taskID' => $taskID]);
    }
}