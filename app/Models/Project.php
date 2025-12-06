<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'project_name',
        'title',
        'description',
        'image',
        'target_amount',
        'current_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
}
