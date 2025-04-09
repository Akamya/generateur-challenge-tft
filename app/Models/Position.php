<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function challenges() {
        return $this->hasMany(Challenge::class);
    }
}
