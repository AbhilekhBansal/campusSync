<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
