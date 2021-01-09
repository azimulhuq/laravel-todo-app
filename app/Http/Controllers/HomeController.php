<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Repository\TaskRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $taskRepository;
    /**
     * Create a new controller instance.
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $tasks = $this->taskRepository->getRecentTasksOfCurrentUser(6);
        return view('home', ['tasks' => $tasks]);
    }
}
