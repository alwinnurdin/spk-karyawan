<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'scores';

    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'value'
    ];

    public function alternative()
    {
        return $this->belongsTo(User::class);
    }
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
