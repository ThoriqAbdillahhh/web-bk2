<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    public const STATUSES = ['menunggu', 'diproses', 'selesai'];

    // 'status' sengaja tidak masuk fillable: hanya guru yang boleh mengubahnya
    protected $fillable = ['topic'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}