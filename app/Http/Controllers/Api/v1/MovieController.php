<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\ReviewResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->search, function($query) use ($request) {
                $query->where('title', 'like', "%{$request->search}%")
                    ->orWhere('genre', 'like', "%{$request->search}%");
            })
            ->paginate(10);

        return $this->success('Movies retrieved', MovieResource::collection($movies));
    }

    public function store(MovieStoreRequest $request)
    {
        $movie = Movie::create($request->validated());
        return $this->success('Movie created', new MovieResource($movie), 201);
    }

    public function show(Movie $movie)
    {
        $movie->load(['reviews' => fn($q) => $q->latest()]);
        return $this->success('Movie retrieved', [
            'movie' => new MovieResource($movie),
            'reviews' => ReviewResource::collection($movie->reviews)
        ]);
    }
}
