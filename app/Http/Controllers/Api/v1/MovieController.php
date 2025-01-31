<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Resources\MovieResource;
use App\Http\Resources\ReviewResource;
use App\Models\Movie;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        try {
            $movies = Movie::withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->when($request->search, function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->search}%")
                        ->orWhere('genre', 'like', "%{$request->search}%");
                })
                ->paginate(10);

            return $this->success('Movies retrieved', MovieResource::collection($movies));
        } catch (Exception $e) {
            Log::error("Movie Index Error: " . $e->getMessage());
            return $this->error('Failed to retrieve movies. Please try again later.', [], 500);
        }
    }

    public function store(MovieStoreRequest $request)
    {
        try {
            $movie = Movie::create($request->validated());
            return $this->success('Movie created', new MovieResource($movie), 201);
        } catch (ValidationException $e) {
            return $this->error('Validation Error', $e->errors(), 422);
        } catch (Exception $e) {
            Log::error("Movie Creation Error: " . $e->getMessage());
            return $this->error('Failed to create movie. Please try again.', [], 500);
        }
    }

    public function update(MovieStoreRequest $request, Movie $movie)
    {
        try {
            $validated = $request->validated();

            // Ensure the title is unique except for the current movie
            if (isset($validated['title']) && $movie->title !== $validated['title']) {
                $request->validate([
                    'title' => 'unique:movies,title,' . $movie->id,
                ]);
            }

            $movie->update($validated);

            return $this->success('Movie updated successfully', new MovieResource($movie));
        } catch (ValidationException $e) {
            return $this->error('Validation Error', $e->errors(), 422);
        } catch (Exception $e) {
            Log::error("Movie Update Error: " . $e->getMessage());
            return $this->error('Failed to update movie. Please try again.', [], 500);
        }
    }



    public function show($id)
    {
        try {
            $movie = Movie::findOrFail($id);
            $movie->load(['reviews' => fn($q) => $q->latest()]);

            return $this->success('Movie retrieved', [
                'movie' => new MovieResource($movie),
                'reviews' => ReviewResource::collection($movie->reviews)
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error("Movie Show Error - Not Found: " . $e->getMessage());
            return $this->error('Movie not found', [], 404);
        } catch (Exception $e) {
            Log::error("Movie Show Error: " . $e->getMessage());
            return $this->error('Failed to retrieve movie details. Please try again.', $e->getMessage(), 500);
        }
    }

    public function destroy(Movie $movie)
    {
        try {
            $movie->delete();
            return $this->success('Movie deleted successfully', null, 200);
        } catch (ModelNotFoundException $e) {
            Log::error("Movie Not Found: {$e->getMessage()}");
            return $this->error('Movie not found', [], 404);
        } catch (Exception $e) {
            Log::error("Movie Deletion Error: {$e->getMessage()}");
            return $this->error('Failed to delete movie. Please try again.', [], 500);
        }
    }
}
