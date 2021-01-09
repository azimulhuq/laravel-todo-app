<?php
namespace App\Repository;

use App\Models\Task;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskRepository {
    use AuthTrait;
    public function __construct()
    {
    }

    public function getTasksOfCurrentUser()
    {
        $this->userAuthCheck();
        $userId = Auth::id();
        return Task::where('user_id', $userId)
            ->orderBy('end_time', 'asc')->get();

    }

    public function getTaskCountOfCurrentUser()
    {
        return count($this->getTasksOfCurrentUser());
    }

    public function getRecentTasksOfCurrentUser($noOfTasks = 5)
    {
        $userId = Auth::id();
        return Task::where('user_id', $userId)
            ->orderBy('end_time', 'asc')
            ->whereDate('end_time', '>', new \DateTime())
            ->take($noOfTasks)
            ->get();
    }

    public function createTask($task)
    {
        $endTime = (new \DateTime($task['end_time']))->format('Y-m-d h:i:s');
        $userId = Auth::id();
        $task = Task::create([
            'name' => $task['name'],
            'description' => $task['description'],
            'end_time' => $endTime,
            'user_id' => $userId
        ]);

        if (!$task) {
            throw new \Exception('Error saving task');
        }

        return $task;
    }

    public function getTaskById($id)
    {
        return Task::findOrFail($id);
    }

    public function checkIfAuthorized($id)
    {
        $task = Task::where("id", $id)->first();
        if ($task->user_id !== Auth::id()) {
            throw new \Exception("You do not have access to modify this task");
        }
    }
    public function updateTask($id, $task)
    {
        if($id === null || !isset($id)) {
            throw new Exception('Task id is required');
        }
        return Task::where("id", $id)->update($task);
    }

    public function deleteTaskById($id)
    {
        $this->getTaskById($id)->delete();
    }
}
