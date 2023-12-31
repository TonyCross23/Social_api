<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','description'];

    // user 
    public function user () {
        return $this->belongsTo(User::class,'user_id','id');
    }

        // media
       public function image () {
        return $this->morphOne(Media::class, 'model');
    }

    // commet
    public function comment () {
        return $this->hasMany(Comment::class);
    }

}