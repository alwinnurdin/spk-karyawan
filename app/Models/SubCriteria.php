<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCriteria extends Model
{
    protected $table = 'subcriterias';

    protected $fillable = [
        'criteria_id',
        'name',
        'value'
    ];
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
