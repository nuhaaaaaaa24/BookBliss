<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'bio',
        'interests'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 📚 Books
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // 🏆 Challenges created
    public function createdChallenges()
    {
        return $this->hasMany(Challenge::class);
    }

    // 🏃 Joined challenges
    public function challenges()
    {
        return $this->belongsToMany(Challenge::class);
    }

    // 📝 Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // ❤️ Likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}