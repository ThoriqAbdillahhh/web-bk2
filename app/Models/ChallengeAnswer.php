<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChallengeAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_id',
        'selected_option_id',
        'answer_order',
        'attempt_number',
        'is_correct',
        'submitted_at',
    ];

    protected $casts = [
        'answer_order' => 'array',
        'attempt_number' => 'integer',
        'is_correct' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function challenge(): BelongsTo
    {
        return $this->belongsTo(Challenge::class);
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(ChallengeOption::class, 'selected_option_id');
    }
}
