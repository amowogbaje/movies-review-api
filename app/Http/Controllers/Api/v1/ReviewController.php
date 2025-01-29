<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewStoreRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Movie $movie, ReviewStoreRequest $request)
    {
        $review = $movie->reviews()->create([
            'user_id' => auth()->id(),
            ...$request->validated()
        ]);

        return $this->success('Review submitted', new ReviewResource($review), 201);
    }
}
