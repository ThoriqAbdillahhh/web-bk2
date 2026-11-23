<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeValue extends Model
{
    use HasFactory;

    protected $fillable = ['selected'];

    protected $casts = [
        'selected' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}