<?php

namespace App\Models;

use App\Framework\Model;

class Task extends Model
{
    public ?int $taskID;
    public ?User $user;
    public string $title;
    public string $description;
    public bool $isCompleted;
    public bool $isDeleted;
    public int $estimatedCycles;
    /**
     * @var Subtask[]
     */
    public ?array $subtasks;
    /**
     * @var Session[]
     */
    public array $sessions;

    public function __construct(array $data = [], array $sessions = [], ?array $subtasks = null)
    {
        $this->taskID = $data['taskID'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->isCompleted = $data['isCompleted'] ?? false;
        $this->isDeleted = $data['isDeleted'] ?? false;
        $this->estimatedCycles = $data['estimatedCycles'] ?? 0;
        $this->user = $data['userID'] ? new User($data) : null;
        $this->subtasks = $subtasks;
        $this->sessions = $sessions;
    }
}
