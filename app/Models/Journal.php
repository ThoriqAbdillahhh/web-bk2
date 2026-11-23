<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = ['week_no', 'q1', 'q2', 'q3', 'is_shared'];

    protected $casts = ['is_shared' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {   
        return $this->hasOne(JournalFeedback::class);
    }

}