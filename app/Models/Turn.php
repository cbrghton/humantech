<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turn extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'turn_at',
        'active'
    ];

    /**
     * Relation many to many between Turn and Movie Models
     *
     * @return BelongsToMany
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
