<?php

namespace App\Contracts\Repositories;

interface BaseRepositoryInterface
{
    public function paginate($perPage = 15, $filter = null);

    public function findOneById(int $id);

    public function destroy(int $id);

    public function insert($data);

    public function update(int $id, array $data);
}
