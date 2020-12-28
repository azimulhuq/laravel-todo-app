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
            'name' => 'required|min:10|max:255',
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

        return view('tasks.edit', [
            'task' => $this->taskRepository->getTaskById($id)
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:10|max:255',
            'description' => 'required|string',
            'end_time' => 'required|after:today'
        ]);

        $task = $this->taskRepository->getTaskById($request->id);
        $endTime = (new \DateTime($request->end_time))->format('Y-m-d h:i:s');
        $userId = Auth::id();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->end_time = $endTime;
        $task->user_id = $userId;

        $updateTask = $task->save();

        if($updateTask) {
            return redirect(route('tasks.all'));
        } else {
            return view('404');
        }
    }

    public function delete($id)
    {
        $this->taskRepository->deleteTaskById($id);
        return redirect()->back();
    }
}
