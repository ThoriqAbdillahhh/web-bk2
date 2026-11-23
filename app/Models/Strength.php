<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strength extends Model
{
    use HasFactory;

    public const KINDS = ['kekuatan', 'minat'];

    protected $fillable = ['kind', 'title', 'example'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}