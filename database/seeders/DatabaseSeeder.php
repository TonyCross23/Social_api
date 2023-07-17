<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feed;
use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // user create
       User::create([
            'name' => 'Aung Ko Oo',
            'email' => 'aungkooo@gmail.com',
            'password' => Hash::make('password'),
       ]);

       // feed
       Feed::create([
        'user_id' => 1,
        'description' => 'Hello World',
       ]);

    // comment
    Comment::create([
        'user_id' => 1,
        'feed_id' => 1,
        'comment' => 'Good Post',
    ]);
    
    //like
    Like::create([
        'user_id' => 1,
        'feed_id' => 1,
    ]); 

    }
}