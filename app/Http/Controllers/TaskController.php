<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Repository\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private TaskRepository $taskRepository;
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->middleware('auth');
    }

    public function list()
    {
        $tasks = $this->taskRepository->getTasksOfCurrentUser();
        return view('tasks.list', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:8|max:255',
            'description' => 'required|string',
            'end_time' => 'required|after:today'
        ]);
        $saveTask = $this->taskRepository->createTask($request->except('_token'));

        if($saveTask) {
            return redirect(route('tasks.all'));
        } else {
            return view('404');
        }
    }

    public function edit($id)
    {
        $this->taskRepository->checkIfAuthorized($id);
        return view('tasks.edit', [
            'task' => $this->taskRepository->getTaskById($id)
        ]);
    }

    public function update($taskId, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:8|max:255',
            'description' => 'required|string',
            'end_time' => 'required|after:today'
        ]);

        $this->taskRepository->checkIfAuthorized($taskId);
        $task = $this->taskRepository->updateTask($taskId, $request->except('_token'));

        if($task) {
            return redirect(route('tasks.all'));
        } else {
            return view('404');
        }
    }

    public function complete($taskId)
    {
        $this->taskRepository->checkIfAuthorized($taskId);
        $task = $this->taskRepository->updateTask($taskId, [
            'status' => config('status.Completed')
        ]);
        if($task) {
            return redirect(route('tasks.all'));
        } else {
            return view('404');
        }
    }

    public function pending($taskId)
    {
        $this->taskRepository->checkIfAuthorized($taskId);
        $task = $this->taskRepository->updateTask($taskId, [
            'status' => config('status.Pending')
        ]);
        if($task) {
            return redirect(route('tasks.all'));
        } else {
            return view('404');
        }
    }

    public function delete($id)
    {
        $this->taskRepository->checkIfAuthorized($id);
        $this->taskRepository->deleteTaskById($id);
        return redirect()->back();
    }
}
