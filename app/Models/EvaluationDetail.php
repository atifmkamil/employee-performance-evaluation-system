<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationDetail extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['evaluation_id', 'criteria_id', 'value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
