<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewStoreRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ReviewResource;
use App\Models\Movie;
use Exception;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Movie $movie, ReviewStoreRequest $request)
    {
        try {
            // Check if the user has already reviewed this movie
            if ($movie->reviews()->where('user_id', auth()->id())->exists()) {
                return $this->error('You have already reviewed this movie', [], 409);
            }

            // Create the review
            $review = $movie->reviews()->create([
                'user_id' => auth()->id(),
                ...$request->validated()
            ]);

            return $this->success('Review submitted', new ReviewResource($review), 201);
        } catch (ValidationException $e) {
            return $this->error('Validation Error', $e->errors(), 422);
        } catch (QueryException $e) {
            Log::error("Database error while submitting review: {$e->getMessage()}");
            return $this->error('Failed to submit review. Please try again.', [], 500);
        } catch (Exception $e) {
            Log::error("Unexpected error while submitting review: {$e->getMessage()}");
            return $this->error('An unexpected error occurred. Please try again.', [], 500);
        }
    }
}
