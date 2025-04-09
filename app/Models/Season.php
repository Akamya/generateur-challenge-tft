<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    public function challenges() {
        return $this->hasMany(Challenge::class);
    }

    public function classes() {
        return $this->hasMany(Classe::class);
    }

    public function origins() {
        return $this->hasMany(Origin::class);
    }
}
