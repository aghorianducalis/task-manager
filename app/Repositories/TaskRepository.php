<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TaskRepository implements TaskRepositoryInterface
{
    public function getList(array $filters = [])
    {
        $query = Task::query();

        // todo improve filters
        foreach ($filters as $field => $value) {
            $query->where($field, $value);
        }

        return $query->get();
    }

    public function find($id)
    {
        return Task::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $task = Task::query()->create($data);

            if (isset($data['user_id'])) {
                $task->user()->associate($data['user_id']);
                $task->save();
            }

            return $task;
        });
    }

    public function update($id, array $data)
    {
        $task = $this->find($id);

        return DB::transaction(function () use ($task, $data) {
            $task->update($data);

            if (isset($data['user_id'])) {
                $task->user()->associate($data['user_id']);
                $task->save();
            }

            return $task;
        });
    }

    public function delete($id): bool
    {
        /** @var Task $task */
        $task = Task::query()->findOrFail($id);
        $result = $task->delete();

        return $result;
    }
}
