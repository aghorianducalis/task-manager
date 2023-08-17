<?php

namespace Tests\Feature\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Http\Controllers\TaskController
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * @covers ::index
     */
    public function testIndex()
    {
        Task::factory(3)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }


    /**
     * @test
     * @covers ::store
     */
    public function testCreate()
    {
        $taskData = Task::factory()->make()->toArray();

        $response = $this->postJson(route('tasks.store'), $taskData);

        $response->assertStatus(201)
            ->assertJsonFragment($taskData);
    }


    /**
     * @test
     * @covers ::show
     */
    public function testShow()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.show', $task->id));

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }


    /**
     * @test
     * @covers ::update
     */
    public function testUpdate()
    {
        $taskData = Task::factory()->create();
        $user = User::factory()->create();
        $updatedData = [
            'title'       => 'Updated Title',
            'description' => 'Updated Description',
            'user_id'     => $user->id,
        ];

        $response = $this->putJson(route('tasks.update', $taskData->id), $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
    }


    /**
     * @test
     * @covers ::destroy
     */
    public function testDestroy()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson(route('tasks.destroy', $task->id));

        $response->assertStatus(200)
            ->assertExactJson(['result' => true]);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
