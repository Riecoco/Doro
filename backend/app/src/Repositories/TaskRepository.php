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
            SELECT T.taskID, T.userID, T.title, T.description, T.isCompleted, T.estimatedCycles,
            S.subtaskID, S.title, S.isCompleted,
            Se.sessionID, Se.startTime, Se.endTime, Se.isCompleted,
            TC.timerConfigID, TC.userID, TC.shortBreakDuration, TC.longBreakDuration, TC.focusDuration
            FROM Tasks as T
            LEFT JOIN Subtasks as S ON T.taskID = S.taskID
            LEFT JOIN Sessions as Se ON T.taskID = Se.taskID
            LEFT JOIN TimerConfigs as TC ON Se.timerConfigID = TC.timerConfigID
            WHERE T.userID = :userID AND T.isCompleted = 0";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute(['userID' => $userID]);
        $tasks = [];
        $results = $stmt->fetchAll();
        foreach ($results as $result) {
            $taskID = $result['taskID'];
            if (!isset($tasks[$taskID])) {
                $tasks[$taskID] = new Task($result);
            }
            $this->fillTasksWithSubtasksSessionsAndTimerConfigs($tasks[$taskID], $result);
        }
        return array_values($tasks);
    }

    private function fillTasksWithSubtasksSessionsAndTimerConfigs(Task $task, array $results): void
    {
        if ($results['sessionID']) {
            // check if session already exists in task sessions
            $sessionExists = !empty(array_filter(
                $task->sessions,
                fn($session) => $session->sessionID === $results['sessionID']
            ));
            if (!$sessionExists) {
                $task->sessions[] = new Session($results);
            }
        }
        // check if subtask exists and if it already exists in task subtasks
        if ($results['subtaskID']) {
            $subtaskExists = !empty(array_filter(
                $task->subtasks,
                fn($subtask) => $subtask->subtaskID === $results['subtaskID']
            ));
            if (!$subtaskExists) {
                $task->subtasks[] = new Subtask($results);
            }
        }
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
            'isCompleted' => (int)$task->isCompleted,
            'estimatedCycles' => $task->estimatedCycles,
        ]);
        $taskID = (int)$this->getConnection()->lastInsertId();
        $task->taskID = $taskID;
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
            'isCompleted' => $task->isCompleted,
            'estimatedCycles' => $task->estimatedCycles,
        ]);
    }

    public function delete(int $taskID): bool
    {
        $sql = "DELETE FROM Tasks WHERE taskID = :taskID";
        $stmt = $this->getConnection()->prepare($sql);
        return $stmt->execute(['taskID' => $taskID]);
    }
}
