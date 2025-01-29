<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'release_date' => $this->release_date->format('Y-m-d'),
            'genre' => $this->genre,
            'rating' => $this->whenLoaded('reviews', [
                'average' => round($this->reviews->avg('rating'), 1),
                'count' => $this->reviews->count(),
            ]),
        ];
    }
}
