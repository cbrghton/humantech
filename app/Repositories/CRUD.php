<?php

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class CRUD
{
    /**
     * Class of model to generate
     *
     * @var Model|string
     */
    protected $model;

    /**
     * Container to generate
     *
     * @var App
     */
    private $app;

    /**
     * CRUD constructor
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Generate model
     *
     * @return Model
     */
    protected function makeModel()
    {
        return $this->model = $this->app->make($this->modelClass());
    }

    /**
     * Specify the model class
     *
     * @return string
     */
    abstract protected function modelClass();

    /**
     * Get all records
     *
     * @param string $orderBy
     * @param string $order
     * @param int $perPage
     * @return Collection|Model[]
     */
    public function all($orderBy = 'id', $order = 'asc', $perPage = 15)
    {
        return $this->model->orderBy($orderBy, $order)->simplePaginate($perPage);
    }

    /**
     * Get all records by attributes
     *
     * @param array $attributes
     * @return Collection|static[]
     */
    public function allBy(array $attributes)
    {
        return $this->model->where($attributes)->get();
    }

    /**
     * Get all records by a column with different values
     *
     * @param $column
     * @param array $values
     * @return Collection|static[]
     */
    public function allByIn($column, array $values)
    {
        return $this->model->whereIn($column, $values)->get();
    }

    /**
     * Get all records by a column with different values
     *
     * @param $column
     * @param array $values
     * @return Collection|static[]
     */
    public function allByNotIn($column, array $values)
    {
        return $this->model->whereNotIn($column, $values)->get();
    }

    /**
     * Get first record by attributes
     *
     * @param array $attributes
     * @return Model
     */
    public function find(array $attributes)
    {
        return $this->model->where($attributes)->first();
    }

    /**
     * Create new register
     *
     * @param array $fields
     * @return Model
     */
    public function create(array $fields)
    {
        $model = $this->model->fill($fields);
        $model->save();
        return $model;
    }

    /**
     * Update registers by attributes
     *
     * @param array $attributes
     * @param array $fields
     * @return int
     */
    public function update(array $attributes, array $fields)
    {
        return $this->model->where($attributes)->update($fields);
    }

    /**
     * Delete registers by attributes
     *
     * @param array $attributes
     * @return int
     */
    public function delete(array $attributes)
    {
        return $this->model->where($attributes)->delete();
    }
}
