<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'published_at',
        'image_path'
    ];

    /**
     * Relation many to many between Movie and Turn Models
     *
     * @return BelongsToMany
     */
    public function turns()
    {
        return $this->belongsToMany(Turn::class);
    }
}
