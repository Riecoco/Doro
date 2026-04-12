<?php

namespace App\Models;

use App\Framework\Model;
use App\Framework\Annotations\Required;

class Subtask extends Model
{
    public ?int $subtaskID;
    #[Required]
    public int $taskID;
    #[Required]
    public string $subtaskTitle;
    #[Required]
    public bool $isCompleted;

    public function __construct(array $data = [])
    {
        $this->subtaskID = $data['subtaskID'] ?? null;
        $this->taskID = $data['taskID'] ?? 0;
        $this->subtaskTitle = $data['subtaskTitle'] ?? '';
        $this->isCompleted = (bool) ($data['isCompleted'] ?? false);
    }
}