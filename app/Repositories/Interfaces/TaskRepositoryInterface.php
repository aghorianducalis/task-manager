<?php

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    public function all();

    public function create(array  $data);

    public function update($id, array $data);

    public function delete($id): bool;

    public function find($id);
}
