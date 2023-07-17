<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

     protected $fillable = ['user_id','feed_id','comment'];

    //  user 
    public function user () {
        return $this->belongsTo(User::class,'user_id');
    }

    // feed
    public function feed () {
        return $this->belongsTo(Feed::class,'feed_id');
    }
}