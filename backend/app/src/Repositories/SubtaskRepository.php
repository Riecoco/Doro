<?php

namespace App\Repositories;

use App\Framework\Repository;
use App\Models\Subtask;
use App\Models\Task;
use App\Repositories\Interfaces\ISubtaskRepository;

class SubtaskRepository extends Repository implements ISubtaskRepository
{

    public function create(Subtask $subtask): Subtask
    {
        $sql = '
            INSERT INTO Subtasks (taskID, title) 
            VALUES (:taskID, :title)';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute([
            'taskID' => $subtask->taskID,
            'title' => $subtask->title,
        ]);
        $subtask->subtaskID = (int)$this->getConnection()->lastInsertId();
        return $this->getById($subtask->subtaskID);
    }

    private function getById(int $subtaskID): ?Subtask
    {
        $sql = 'SELECT * FROM Subtasks WHERE subtaskID = :subtaskID';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['subtaskID' => $subtaskID]);
        $result = $stmt->fetch();
        return $result ? new Subtask($result) : null;
    }

    public function update(Subtask $subtask): bool
    {
        if (!$subtask->subtaskID) {
            return false;
        }
        $sql = 'UPDATE Subtasks 
                SET title = :title, isCompleted = :isCompleted 
                WHERE subtaskID = :subtaskID';
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute([
            'title' => $subtask->title,
            'isCompleted' => (int)$subtask->isCompleted,
            'subtaskID' => $subtask->subtaskID
        ]);
    }

    public function delete(int $subtaskID): bool
    {
        $sql = 'DELETE FROM Subtasks WHERE subtaskID = :subtaskID';
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['subtaskID' => $subtaskID]);
    }
}
