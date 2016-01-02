<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    public function machine()
    {
        return $this->belongsTo('App\Machine');
    }
}
