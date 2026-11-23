<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalityMap extends Model
{
    use HasFactory;

    public const ANSWERS = ['jarang', 'kadang', 'sering'];

    protected $fillable = ['answers', 'notes'];

    protected $casts = [
        'answers' => 'array',
        'notes'   => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}