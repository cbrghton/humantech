<?php

namespace App\Services;

use App\Repositories\CRUD;
use App\Models\Turn as TurnModel;
use Illuminate\Database\Eloquent\Model;

class Turn extends CRUD
{
    /**
     * Specify the model class
     *
     * @return string
     */
    protected function modelClass()
    {
        return TurnModel::class;
    }

    public function all($orderBy = 'id', $order = 'asc', $perPage = 15)
    {
        return parent::all($orderBy, $order, $perPage)->load('movies');
    }

    /**
     * Get first record by attributes
     *
     * @param array $attributes
     * @return Model
     */
    public function find(array $attributes)
    {
        return parent::find($attributes)->load('movies');
    }

    /**
     * Update registers by attributes
     *
     * @param array $attributes
     * @param array $fields
     * @return Model
     */
    public function update(array $attributes, array $fields)
    {
        parent::update($attributes, $fields);

        return $this->find($attributes);
    }

    /**
     * Sync the middle relation table
     *
     * @param $attributes
     * @param $syncIds
     * @return Model|null
     */
    public function sync($attributes, $syncIds)
    {
        \DB::beginTransaction();

        try {
            $turn = parent::find($attributes);

            $turn->movies()->sync($syncIds);

            $turn->load('movies');

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            return null;
        }

        return $turn;
    }

    /**
     * Delete registers by attributes
     *
     * @param array $attributes
     * @return int
     */
    public function delete(array $attributes)
    {
        \DB::beginTransaction();

        try {
            $turn = parent::find($attributes);

            $turn->movies()->detach();

            $turn = parent::delete($attributes);

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            return 0;
        }

        return $turn;
    }
}
