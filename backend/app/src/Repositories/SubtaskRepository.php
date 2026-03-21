<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Subtask;
use App\Models\Task;
use App\Repositories\Interfaces\ISubtaskRepository;

class SubtaskRepository extends Repository implements ISubtaskRepository
{

    public function createSubtask(Subtask $subtask): int
    {
        $sql = '
            INSERT INTO Subtasks (taskID, title, isCompleted) 
            VALUES (:taskID, :title, :isCompleted)';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            'taskID' => $subtask->taskID,
            'title' => $subtask->title,
        ]);
        return (int)$this->getConnection()->lastInsertId();
    }

    public function updateSubtask(Subtask $subtask): bool
    {
        if (!$subtask->subtaskID) {
            return false;
        }
        $sql = '
            UPDATE Subtasks SET title = :title, isCompleted = :isCompleted WHERE subtaskID = :subtaskID';
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([
            'title' => $subtask->title,
            'isCompleted' => (int)$subtask->isCompleted,
            'subtaskID' => $subtask->subtaskID
        ]);
    }

    public function deleteSubtask(int $subtaskID): bool
    {
        $sql = '
            UPDATE Subtasks SET isDeleted = 1 WHERE subtaskID = :subtaskID';
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['subtaskID' => $subtaskID]);
    }
}
