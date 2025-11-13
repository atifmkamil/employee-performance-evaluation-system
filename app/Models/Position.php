<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    //
    use SoftDeletes;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
