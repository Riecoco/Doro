<?php

namespace App\Controllers;

use App\Models\Subtask;
use App\Framework\Controller;
use App\Services\SubtaskService;
use App\Services\Interfaces\ISubtaskService;

class SubtaskController extends Controller
{
    private ISubtaskService $subtaskService;

    public function __construct()
    {
        $this->subtaskService = new SubtaskService();
    }

    public function create()
    {
        try {
            $subtask = $this->mapPostDataToClass(Subtask::class);
            if (empty($subtask->title) || empty($subtask->task_id)) {
                return $this->sendErrorResponse('Title and task_id are required', 400);
            }
            $createdSubtask = $this->subtaskService->create($subtask);
            return $this->sendSuccessResponse($createdSubtask, 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function update($id)
    {
        try {
            $subtask = $this->mapPostDataToClass(Subtask::class);
            $subtask->id = $id;
            if (empty($subtask->title) || empty($subtask->task_id)) {
                return $this->sendErrorResponse('Title and task_id are required', 400);
            }
            $updated = $this->subtaskService->update($subtask);
            if (!$updated) {
                return $this->sendErrorResponse('Subtask not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'Subtask updated successfully']);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }

    public function delete($id)
    {
        try {
            $deleted = $this->subtaskService->delete($id);
            if (!$deleted) {
                return $this->sendErrorResponse('Subtask not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'Subtask deleted successfully']);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('Internal server error', 500);
        }
    }
}
