<?php

namespace App\Services;

use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskService
{
    protected TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $resourceTypeRepository)
    {
        $this->repository = $resourceTypeRepository;
    }

    public function getTaskById($id): Task
    {
        return $this->repository->find($id);
    }

    public function getTaskList(array $filters = [])
    {
        return $this->repository->getList($filters);
    }

    public function createTask(array $data): Task
    {
        return $this->repository->create($data);
    }

    public function updateTask($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteTask($id): bool
    {
        return $this->repository->delete($id);
    }
}
