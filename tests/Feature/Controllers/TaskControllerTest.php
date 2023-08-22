<?php

namespace Tests\Feature\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
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
        $user = User::factory()->create();
        $tasks = Task::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }

    /**
     * @test
     * @covers ::index
     */
    public function testIndexUserCannotViewOtherUsersTasks()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $taskOfUser2 = Task::factory()->create(['user_id' => $user2->id]);

        $this->actingAs($user1);

        $response = $this->get(route('tasks.index'));

        $response->assertDontSeeText($taskOfUser2->title);
    }

    /**
     * @test
     * @covers ::store
     */
    public function testCreate()
    {
        $user = User::factory()->create();
        $task = Task::factory()->make();
        $taskData = Arr::except($task->toArray(), ['user_id']);

        $response = $this->actingAs($user)->postJson(route('tasks.store'), $taskData);

        $response->assertStatus(201)
            ->assertJsonFragment($taskData);
    }


    /**
     * @test
     * @covers ::show
     */
    public function testShow()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.show', $task->id));

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }


    /**
     * @test
     * @covers ::update
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $taskData = Task::factory()->create(['user_id' => $user->id]);
        $updatedData = [
            'title'       => 'Updated Title',
            'description' => 'Updated Description',
            'user_id'     => $user->id,
        ];

        $response = $this->actingAs($user)->putJson(route('tasks.update', $taskData->id), $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
    }


    /**
     * @test
     * @covers ::destroy
     */
    public function testDestroy()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson(route('tasks.destroy', $task->id));

        $response->assertStatus(200)
            ->assertExactJson(['result' => true]);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
