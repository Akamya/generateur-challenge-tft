<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    public function challenges() {
        return $this->hasMany(Challenge::class);
    }
}
