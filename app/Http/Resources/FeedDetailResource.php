<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\CommetResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedDetailResource extends JsonResource
{
   public function toArray($request)
   {
    return [
        'id' => $this->id,
        'user_name' => optional($this->user)->name ?? 'Unkonw User',
        'description' => Str::limit($this->description,100, '...'),
        'image' => $this->image ? asset('storage/media/' . $this->image->file_name) : null,
         'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i:s A'),
        'created_at_readable' => Carbon::parse($this->created_at)->diffForHumans(),
    ];
   }
}