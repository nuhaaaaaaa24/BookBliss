<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    protected $fillable = [
        'name',
        'goal',
        'start_date',
        'end_date',
        'is_private',
        'user_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}