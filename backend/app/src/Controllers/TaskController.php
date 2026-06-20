<?php

namespace App\Controllers;

use Exception;
use App\Models\Task;
use App\Models\UpdateTaskDTO;
use App\Controllers\BaseController;
use App\Services\TaskService;
use App\Services\Interfaces\ITaskService;

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
            $task->userId = $currentUser->id;
            $createdTask = $this->taskService->create($task);

            return $this->sendSuccessResponse($createdTask, 201);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }

    public function getAll()
    {
        $currentUser = $this->authenticateUser();
        try {
            $isCompleted = isset($_GET['isCompleted']) ? filter_var($_GET['isCompleted'], FILTER_VALIDATE_BOOLEAN) : false;
            $tasks = $this->taskService->getAllByStatusForUser($currentUser->id, $isCompleted);
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

    //this is a patch not put
    public function update($vars = [])
    {
        $currentUser = $this->authenticateUser();
        try {
            $dto = $this->mapPostDataToClass(UpdateTaskDTO::class);
            $dto->id = $vars['id'];
            $updatedTask = $this->taskService->update($dto);
            if ($updatedTask) {
                return $this->sendSuccessResponse($updatedTask);
            } else {
                return $this->sendErrorResponse('Task not found', 404);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }

    public function delete($vars = [])
    {
        $currentUser = $this->authenticateUser();
        try {
            if (!isset($vars['id']) || $this->taskService->getById($vars['id']) === null) {
                return $this->sendErrorResponse('Task not found', 400);
            }
            $this->taskService->delete($vars['id']);
            return $this->sendSuccessResponse(['message' => 'Task deleted']);
        } catch (Exception $e) {
            return $this->sendErrorResponse("Oops, something went wrong!", 500);
        }
    }
}
