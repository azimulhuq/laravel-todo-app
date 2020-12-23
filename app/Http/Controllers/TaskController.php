<?php

namespace App\Http\Controllers;

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
        return view('home', compact('tasks'));
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
            return redirect('/home');
        } else {
            return view('404');
        }
    }
}
