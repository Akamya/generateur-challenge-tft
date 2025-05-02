<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $fillable = [
        'name',
        'technical_name',
    ];

    public function challenges() {
        return $this->hasMany(Challenge::class);
    }

    public function season() {
        return $this->belongsTo(Season::class);
    }
}
