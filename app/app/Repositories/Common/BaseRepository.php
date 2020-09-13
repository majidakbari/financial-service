<?php

namespace App\Repositories\Common;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseRepository implements EloquentRepositoryInterface
{
    abstract protected function model();

    protected array $fillable = [];

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function fill(array $data, Model $object, array $fillable = []): Model
    {
        if (empty($fillable)) {
            $fillable = $this->fillable;
        }

        return $object->fillable($fillable)->fill($data);
    }


    /**
     * @param array $data
     * @param array $fillable
     * @return Model
     * @throws BindingResolutionException
     */
    public function create(array $data, array $fillable = []): Model
    {
        $object = $this->fill($data, $this->makeModel(), $fillable);
        $object->save();

        return $object;
    }

    /**
     * @param array $data
     * @param $object
     * @param array $fillable
     * @return Model
     * @throws BindingResolutionException
     */
    public function update(array $data, $object, array $fillable = []): Model
    {
        if (!($object instanceof Model)) {
            $object = $this->find($object);
        }

        $object = $this->fill($data, $object, $fillable);
        $object->save();

        return $object;
    }

    /**
     * @param Model $object
     * @return bool|null
     * @throws Exception
     */
    public function delete(Model $object): bool
    {
        return $object->delete();
    }

    public function save(Model $object): bool
    {
        return $object->save();
    }

    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     * @throws BindingResolutionException
     */
    public function find(int $id, $columns = ['*']): ?Model
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     * @throws BindingResolutionException
     */
    public function findBy($attribute, $value, $columns = ['*']): ?Model
    {
        return $this->query()->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @return mixed
     * @throws BindingResolutionException
     */
    public function query(): Builder
    {
        return $this->makeModel()->newQuery();
    }

    /**
     * Make model
     *
     * @return Model
     * @throws Exception
     * @throws BindingResolutionException
     */
    public function makeModel(): Model
    {
        $model = $this->container->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model",
            );
        }

        return $model;
    }
}
