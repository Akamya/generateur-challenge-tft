<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Constraint extends Model
{
    public function challenges() {
        return $this->hasMany(Challenge::class);
    }
}
