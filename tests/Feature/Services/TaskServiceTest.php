<?php

namespace Tests\Feature\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Services\TaskService
 */
class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TaskService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $taskRepository = new TaskRepository();
        $this->service = new TaskService($taskRepository);
    }

    /**
     * @test
     * @covers ::getTaskById
     */
    public function testGetTaskById()
    {
        /** @var Task $task */
        $task = Task::factory()->create();

        $foundTask = $this->service->getTaskById($task->id);

        $this->assertInstanceOf(Task::class, $foundTask);
        $this->assertEquals($task->title, $foundTask->title);
        $this->assertEquals($task->description, $foundTask->description);
        $this->assertEquals($task->due_date, $foundTask->due_date);
        $this->assertEqualsCanonicalizing($task->status, $foundTask->status);
        $this->assertEquals($task->user_id, $foundTask->user_id);
    }

    /**
     * @test
     * @covers ::getAllTasks
     */
    public function testGetAllTasks()
    {
        Task::factory(5)->create();

        $tasks = $this->service->getAllTasks();

        $this->assertCount(5, $tasks);
    }

    /**
     * @test
     * @covers ::createTask
     */
    public function testCreate()
    {
        $data = Task::factory()->make()->toArray();

        $task = $this->service->createTask($data);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals($data['title'], $task->title);
        $this->assertEquals($data['description'], $task->description);
        $this->assertEquals($data['due_date'], $task->due_date->toISOString());
        $this->assertEquals($data['status'], $task->status->value);
        $this->assertEquals($data['user_id'], $task->user_id);
        $this->assertDatabaseHas($task->getTable(), [
            'id'          => $task->id,
            'title'       => $data['title'],
            'description' => $data['description'],
            'due_date'    => $data['due_date'],
            'status'      => $data['status'],
            'user_id'     => $task->user_id,
        ]);
    }

    /**
     * @test
     * @covers ::updateTask
     */
    public function testUpdate()
    {
        $task = Task::factory()->create();
        $newData = Task::factory()->make()->toArray();
        $user = User::factory()->create();

        $updatedTask = $this->service->updateTask($task->id, array_merge($newData, ['user_id' => $user->id]));

        $this->assertInstanceOf(Task::class, $updatedTask);
        $this->assertEquals($newData['title'], $updatedTask->title);
        $this->assertEquals($newData['description'], $updatedTask->description);
        $this->assertEquals($newData['due_date'], $updatedTask->due_date->toISOString());
        $this->assertEquals($newData['status'], $updatedTask->status->value);
        $this->assertEquals($user->id, $updatedTask->user_id);
        $this->assertDatabaseHas($task->getTable(), [
            'id'          => $task->id,
            'title'       => $newData['title'],
            'description' => $newData['description'],
            'due_date'    => $newData['due_date'],
            'status'      => $newData['status'],
            'user_id'     => $user->id,
        ]);
    }

    /**
     * @test
     * @covers ::deleteTask
     */
    public function testDelete()
    {
        $task = Task::factory()->create();

        $result = $this->service->deleteTask($task->id);

        $this->assertTrue($result);

        $this->expectException(ModelNotFoundException::class);
        $this->service->getTaskById($task->id);
        $this->assertDatabaseMissing($task->getTable(), [
            'id' => $task->id
        ]);
    }
}
