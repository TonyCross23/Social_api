<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Feed;
use App\Models\Like;
use App\Models\Media;
use App\Models\Comment;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // media
       public function image () {
        return $this->morphOne(Media::class, 'model');
    }

    // feed
    public function feed () {
        return $this->hasMany(Feed::class,'user_id');
    }

    // comment 
    public function comment () {
        return $this->hasMany(Comment::class,'user_id');
    }

    // like
    public function like () {
        return $this->hasOne(Like::class,'user_id');
    }
}