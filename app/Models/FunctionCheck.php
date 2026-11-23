<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FunctionCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_number',
        'title',
        'status',
        'notes',
        'checked_by',
        'checked_at',
    ];

    protected $casts = [
        'item_number' => 'integer',
        'checked_at' => 'datetime',
    ];

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}
