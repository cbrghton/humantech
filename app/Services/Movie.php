<?php

namespace App\Services;

use App\Repositories\CRUD;
use App\Models\Movie as MovieModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Movie extends CRUD
{
    /**
     * Specify the model class
     *
     * @return string
     */
    protected function modelClass()
    {
        return MovieModel::class;
    }

    public function all($orderBy = 'id', $order = 'asc', $perPage = 15)
    {
        $movies = parent::all($orderBy, $order, $perPage);

        $movies->load('turns');

        return $movies;
    }

    /**
     * Create new register
     *
     * @param array $fields
     * @return Model ;
     */
    public function create(array $fields)
    {
        $path = $fields[ 'image' ]->store('movies');

        $fields[ 'image_path' ] = $path;

        return parent::create($fields);
    }

    /**
     * Get first record by attributes
     *
     * @param array $attributes
     * @return Model
     */
    public function find(array $attributes)
    {
        $movie = parent::find($attributes);

        $image_path = $movie->getAttribute('image_path');

        $movie->setAttribute('image', base64_encode(Storage::get($image_path)));

        $movie->load('turns');

        return $movie;
    }

    /**
     * Update registers by attributes
     *
     * @param array $attributes
     * @param array $fields
     * @return Model|null
     */
    public function update(array $attributes, array $fields)
    {
        \DB::beginTransaction();

        try {
            if (isset($fields[ 'image' ])) {
                Storage::delete(parent::find($attributes)->getAttribute('image_path'));

                $path = $fields[ 'image' ]->store('movies');

                $fields[ 'image_path' ] = $path;
            }

            parent::update($attributes, $fields);

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            return null;
        }

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
            $movie = parent::find($attributes);

            $movie->turns()->sync($syncIds);

            $movie->load('turns');

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            return null;
        }

        return $movie;
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
            $movie = parent::find($attributes);

            $movie->turns()->detach();

            $movie = parent::delete($attributes);

            \DB::commit();
        } catch (\Exception $exception) {
            \DB::rollBack();

            return 0;
        }

        return $movie;
    }
}
