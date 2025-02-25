<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criteria extends Model
{
    protected $table = 'criterias';

    protected $fillable = [
        'name',
        'weight',
        'attribute'
    ];

    public function subcriteria(): HasMany
    {
        return $this->hasMany(SubCriteria::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Add a model event for deleting
        static::deleting(function ($criteria) {
            // Delete all related orders
            $criteria->subcriteria()->delete();
        });
    }
}