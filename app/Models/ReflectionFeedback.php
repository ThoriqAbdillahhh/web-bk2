<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReflectionFeedback extends Model
{
    use HasFactory;

    protected $table = 'reflection_feedback';

    protected $fillable = [
        'reflection_id',
        'teacher_id',
        'content',
    ];

    public function reflection(): BelongsTo
    {
        return $this->belongsTo(Reflection::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
