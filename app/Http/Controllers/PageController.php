<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the application welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        return view('pages.welcome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('pages.home');
    }

    public function taskIndex(Request $request, TaskService $service)
    {
        $this->authorize('viewAny', Task::class);
        $tasks = $service->getTaskList(['user_id' => auth()->user()->id]);

        return view('pages.tasks.index', compact('tasks'));
    }

    public function taskCreate()
    {
        $this->authorize('create', Task::class);
        $statuses = TaskStatusEnum::getStatuses();

        return view('pages.tasks.create', compact('statuses'));
    }

    public function taskShow(Request $request, TaskService $service, $id)
    {
        $task = $service->getTaskById($id);
        $this->authorize('view', $task);

        return view('pages.tasks.show', compact('task'));
    }

    public function taskStore(StoreTaskRequest $request, TaskService $service)
    {
        $this->authorize('create', Task::class);
        $task = $service->createTask(array_merge($request->validated(), ['user_id' => auth()->user()->id]));

        return to_route('pages.tasks.show', ['id' => $task->id])->with('success', 'Task created!');
    }

    public function taskEdit(Request $request, TaskService $service, $id)
    {
        $task = $service->getTaskById($id);
        $this->authorize('view', $task);
        $statuses = TaskStatusEnum::getStatuses();

        return view('pages.tasks.edit', compact('task', 'statuses'));
    }

    public function taskUpdate(UpdateTaskRequest $request, int $taskId, TaskService $service)
    {
        $task = $service->getTaskById($taskId);

        $this->authorize('update', $task);

        $task = $service->updateTask($taskId, $request->validated());

        return to_route('pages.tasks.show', ['id' => $taskId])->with('success', 'Task updated!');
    }

    public function taskDestroy(int $taskId, TaskService $service)
    {
        $task = $service->getTaskById($taskId);

        $this->authorize('delete', $task);

        $result = $service->deleteTask($taskId);

        if ($result === false) {
            return back()->with('success', 'Task was not deleted!');
        }

        return to_route('pages.tasks.index')->with('success', 'Task deleted!');
    }
}
