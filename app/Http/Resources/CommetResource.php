<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommetResource extends JsonResource
{
  public function toArray($request)
  {
    return [
        'user_name' => $this->user->name,
        'comment' => $this->comment,
        'created_at_readable' => Carbon::parse($this->created_at)->diffForHumans(),
    ];
  }
}