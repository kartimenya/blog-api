<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'picture' => $this->picture,
            'user_id' => $this->user_id,
            'tags' => TagResource::collection($this->tags),
            'likes' => $this->likes()->count(),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
