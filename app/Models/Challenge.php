<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'position_id',
        'origin_id',
        'classe_id',
        'constraint_id',
        'season_id',
        'user_id'
    ];

    public const ACTIVE = 'active';
    public const COMPLETED = 'completed';
    public const FAILED = 'failed';

    public static function status(): array
    {
        return [
            self::ACTIVE,
            self::COMPLETED,
            self::FAILED,
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function season() {
        return $this->belongsTo(Season::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function constraint() {
        return $this->belongsTo(Constraint::class);
    }

    public function classe() {
        return $this->belongsTo(Classe::class);
    }

    public function origin() {
        return $this->belongsTo(Origin::class);
    }
}
