<?php

namespace App\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Subtask;
use App\Controllers\BaseController;
use App\Services\TaskService;
use App\Services\Interfaces\ITaskService;
use App\Services\SubtaskService;

class TaskController extends BaseController
{
    private ITaskService $taskService;

    public function __construct()
    {
        parent::__construct();
        $this->taskService = new TaskService();
    }

    public function create()
    {
        $currentUser = $this->authenticateUser();
        try {
            $task = $this->mapPostDataToClass(Task::class);
            $task->userID = $currentUser->id; // Ensure the task is linked to the current user
            // 1. FIRST create the main task to get a taskID for the subtasks
            $createdTask = $this->taskService->create($task);

            return $this->sendSuccessResponse($createdTask, 201);
        } catch (Exception $e) {
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }

    public function getAll()
    {
        $currentUser = $this->authenticateUser();
        try {
            $tasks = $this->taskService->getAll($currentUser->id);
            return $this->sendSuccessResponse($tasks);
        } catch (Exception $e) {
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }

    public function getById($vars = [])
    {
        $currentUser = $this->authenticateUser();
        try {
            $task = $this->taskService->getById($vars['id']);
            if (!$task) {
                return $this->sendErrorResponse('Task not found', 404);
            }
            return $this->sendSuccessResponse($task);
        } catch (Exception $e) {
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }

    public function update($vars = [])
    {
        $currentUser = $this->authenticateUser();
        try {
            $task = $this->mapPostDataToClass(Task::class);
            if (empty($task->title) || empty($task->description)) {
                return $this->sendErrorResponse('Title and description are required', 400);
            }
            $updatedTask = $this->taskService->update($task);
            if (!$updatedTask) {
                return $this->create();
            }
            return $this->sendSuccessResponse($updatedTask);
        } catch (Exception $e) {
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }

    public function delete($vars = [])
    {
        $currentUser = $this->authenticateUser();
        try {
            $deleted = $this->taskService->delete($vars['id']);
            if (!$deleted) {
                return $this->sendErrorResponse('Task not found', 404);
            }
            return $this->sendSuccessResponse(['message' => 'Task deleted']);
        } catch (Exception $e) {
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }
}