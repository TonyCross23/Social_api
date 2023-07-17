<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommnetResource extends JsonResource
{
  public function toArray(Request $request)
  {
    return [
        'comment' => $this->comment,
        'created_at' => Carbon::parse($this->created_at)->format('Y-m-d h:i:s A'),
        'created_at_readable' => Carbon::parse($this->created_at)->diffForHumans(),
    ];
  }
}