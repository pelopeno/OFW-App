<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action_type',
        'remarks',
    ];

    // Optional: relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
