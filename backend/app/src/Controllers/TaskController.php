<?php

namespace App\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Subtask;
use App\Framework\Controller;
use App\Services\TaskService;
use App\Services\Interfaces\ITaskService;
use App\Services\SubtaskService;
use App\Services\Interfaces\ISubtaskService;

class TaskController extends Controller
{
    private ITaskService $taskService;
    private ISubtaskService $subtaskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
        $this->subtaskService = new SubtaskService();
    }

    public function create()
    {
        try {
            $task = $this->mapPostDataToClass(Task::class);

            // 1. FIRST create the main task to get a taskID for the subtasks
            $createdTask = $this->taskService->create($task);

            // 2. THEN create subtasks, now that taskID exists
            if (!empty($task->subtasks)) {
                foreach ($task->subtasks as $subtaskData) {
                    $subtaskData['taskID'] = $createdTask->taskID; // link to parent task
                    $subtask = new Subtask($subtaskData);
                    $this->subtaskService->create($subtask);
                }
            }

            // 3. Re-fetch so the response includes the subtasks
            $fullTask = $this->taskService->getById($createdTask->taskID);
            return $this->sendSuccessResponse($fullTask, 201);
        } catch (Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function getAll($vars)
    {
        try {
            $tasks = $this->taskService->getAll($vars['userID']);
            return $this->sendSuccessResponse($tasks);
        } catch (Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function getById($vars = [])
    {
        try {
            $task = $this->taskService->getById($vars['id']);
            if (!$task) {
                return $this->sendErrorResponse('Task not found', 404);
            }
            return $this->sendSuccessResponse($task);
        } catch (Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function update($vars = [])
    {
        try {
            $task = $this->mapPostDataToClass(
                Task::class
            );
            if (empty($task->title) || empty($task->description)) {
                return $this->sendErrorResponse('Title and description are required', 400);
            }
            $updatedTask = $this->taskService->update($vars['id'], $task);
            if (!$updatedTask) {
                return $this->sendErrorResponse('Task not found', 404);
            }
            return $this->sendSuccessResponse($updatedTask);
        } catch (Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function delete($vars = [])
    {
        try {
            $deleted = $this->taskService->delete($vars['id']);
            if (!$deleted) {
                return $this->sendErrorResponse('Task not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'Task deleted']);
        } catch (Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }
}
