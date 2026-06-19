<?php

namespace App\Models;

use App\Framework\Annotations\Required;
use App\Framework\Model;
use DateTime;

class Task extends Model
{
    public ?int $id;
    public int $userId;
    #[Required]
    public string $title;
    #[Required]
    public bool $isCompleted;

    public DateTime $createdAt;

    public function __construct(array $data = [])
    {
        $this->id = $data['taskID'] ?? $data['id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->isCompleted = (bool) ($data['isCompleted'] ?? false);
        $this->userId = $data['userId'] ?? 0;
        $this->createdAt = new DateTime($data['createdAt'] ?? 'now');
    }
}
