<?php

namespace App\Models;

use App\Framework\Annotations\Required;
use App\Framework\Model;

class Task extends Model
{
    public ?int $taskID;
    public ?User $user;
    #[Required]
    public string $title;
    #[Required]
    public string $description;
    #[Required]
    public bool $isCompleted;
    #[Required]
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
        $this->estimatedCycles = $data['estimatedCycles'] ?? 0;
        $this->user = $data['userID'] ? new User($data) : null;
        $this->subtasks = $subtasks;
        $this->sessions = $sessions;
    }
}
