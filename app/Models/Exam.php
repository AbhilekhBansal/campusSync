<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
