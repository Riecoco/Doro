<?php

namespace App\Models;

use App\Framework\Model;

class Subtask extends Model
{
    public ?int $subtaskID;
    public int $taskID;
    public string $title;
    public bool $isCompleted;
    public bool $isDeleted;

    public function __construct(array $data = [])
    {
        $this->subtaskID = $data['subtaskID'] ?? null;
        $this->taskID = $data['taskID'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->isCompleted = $data['isCompleted'] ?? false;
        $this->isDeleted = $data['isDeleted'] ?? false;
    }
}
