<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalFeedback extends Model
{
    use HasFactory;

    protected $fillable = ['journal_id', 'teacher_id', 'content'];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}