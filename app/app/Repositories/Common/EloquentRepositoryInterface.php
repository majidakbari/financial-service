<?php

namespace App\Repositories\Common;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function create(array $data): Model;
    public function update(array $data, $id): Model;
    public function delete(Model $model): bool;
    public function find(int $id, $columns = ['*']): ?Model;
    public function findBy($field, $value, $columns = ['*']): ?Model;
}
