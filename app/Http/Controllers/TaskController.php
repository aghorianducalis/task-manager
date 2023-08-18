<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\TaskCollection
     */
    public function index(Request $request, TaskService $service)
    {
        $this->authorize('viewAny', Task::class);
        $tasks = $service->getTaskList(['user_id' => auth()->user()->id]);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTaskRequest $request
     * @return \App\Http\Resources\TaskResource
     */
    public function store(StoreTaskRequest $request, TaskService $service)
    {
        $this->authorize('create', Task::class);
        $task = $service->createTask(array_merge($request->validated(), ['user_id' => auth()->user()->id]));

        return (new TaskResource($task))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $taskId
     * @return \App\Http\Resources\TaskResource
     */
    public function show(int $taskId, TaskService $service)
    {
        $task = $service->getTaskById($taskId);
        $this->authorize('view', $task);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTaskRequest $request
     * @param int $taskId
     * @return \App\Http\Resources\TaskResource
     */
    public function update(UpdateTaskRequest $request, int $taskId, TaskService $service)
    {
        $task = $service->getTaskById($taskId);

        $this->authorize('update', $task);

        $task = $service->updateTask($taskId, $request->validated());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $taskId, TaskService $service)
    {
        $task = $service->getTaskById($taskId);

        $this->authorize('delete', $task);

        $result = $service->deleteTask($taskId);

        return response()->json(['result' => $result]);
    }
}
