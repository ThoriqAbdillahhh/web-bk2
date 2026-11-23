<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_id',
        'title',
        'prompt',
        'instructions',
        'challenge_type',
        'level',
        'position',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'position' => 'integer',
        'is_active' => 'boolean',
    ];

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(ChallengeOption::class)->orderBy('position');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ChallengeAnswer::class);
    }
}
