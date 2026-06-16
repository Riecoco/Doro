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
    public ?string $description;
    #[Required]
    public bool $isCompleted;

    public function __construct(array $data = [])
    {
        $this->taskID = $data['taskID'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? null;
        $this->isCompleted = (bool) ($data['isCompleted'] ?? false);
        $this->user = isset($data['userID']) ? new User($data) : null;
    }
}
