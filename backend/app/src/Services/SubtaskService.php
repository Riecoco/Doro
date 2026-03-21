<?php

namespace App\Services;

use App\Models\Subtask;
use App\Repositories\Interfaces\ISubtaskRepository;
use App\Repositories\SubtaskRepository;
use App\Services\Interfaces\ISubtaskService;

class SubtaskService implements ISubtaskService
{
    private ISubtaskRepository $repository;

    public function __construct()
    {
        $this->repository = new SubtaskRepository();
    }

    public function create(Subtask $subtask): Subtask
    {
        return $this->repository->create($subtask);
    }

    public function update(Subtask $subtask): bool
    {
        return $this->repository->update($subtask);
    }

    public function delete(int $subtaskID): bool
    {
        return $this->repository->delete($subtaskID);
    }
}
