<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChallengeOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'label',
        'position',
        'is_correct',
        'correct_position',
        'feedback',
    ];

    protected $casts = [
        'position' => 'integer',
        'is_correct' => 'boolean',
        'correct_position' => 'integer',
    ];

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(ChallengeAnswer::class, 'selected_option_id');
    }
}
