<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function season() {
        return $this->belongsTo(Season::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function formation() {
        return $this->belongsTo(Formation::class);
    }

    public function class() {
        return $this->belongsTo(Classe::class);
    }

    public function origin() {
        return $this->belongsTo(Origin::class);
    }
}
