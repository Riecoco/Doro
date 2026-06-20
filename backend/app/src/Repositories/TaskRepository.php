<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Task;
use App\Models\UpdateTaskDTO;
use App\Repositories\Interfaces\ITaskRepository;

class TaskRepository extends Repository implements ITaskRepository
{
    /**
     * @return Task[]
     * @param int $userID
     * @param bool $isCompleted
     * returns an array of Task objects for a specific user and completion status
     */
    public function getAllByStatusForUser(int $userID, bool $isCompleted): array
    {
        $sql = "
            SELECT T.id, T.userId, T.title, T.isCompleted, T.createdAt
            FROM Tasks as T
            WHERE T.userId = :userId AND T.isCompleted = :isCompleted ORDER BY T.createdAt DESC";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            'userId' => $userID,
            'isCompleted' => (int)$isCompleted
        ]);
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
            WHERE id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['id' => $taskID]);
        $data = $stmt->fetch();
        return $data ? new Task($data) : null;
    }

    public function create(Task $task): Task
    {
        $sql = "
            INSERT INTO Tasks (userId, title, isCompleted, createdAt) 
            VALUES (:userId, :title, :isCompleted, :createdAt)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            'userId' => $task->userId,
            'title' => $task->title,
            'isCompleted' => (int)$task->isCompleted,
            'createdAt' => $task->createdAt->format('Y-m-d H:i:s')
        ]);
        $taskID = (int)$this->getConnection()->lastInsertId();
        return $this->getById($taskID);
    }

    public function update(UpdateTaskDTO $dto): ?Task
    {
        if (!$dto->id) {
            return null;
        }

        $allowedFields = ['title', 'isCompleted'];
        $fieldsToUpdate = array_filter($allowedFields, fn($field) => $dto->hasField($field));
        $sql = "UPDATE Tasks SET " . implode(', ', array_map(fn($field) => "$field = :$field", $fieldsToUpdate))
                                 . " WHERE id = :id";
        $values = [];
        foreach ($fieldsToUpdate as $field) {
            $values[$field] = $dto->$field;
            if ($field === 'isCompleted') {
                $values[$field] = (int) $values[$field];
            }
        }
        $values['id'] = $dto->id;

        $stmt = $this->getConnection()->prepare($sql);
        error_log($sql);
        error_log(print_r($values, true));
        $stmt->execute($values);
        return $this->getById($dto->id);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM Tasks WHERE id = :id";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
