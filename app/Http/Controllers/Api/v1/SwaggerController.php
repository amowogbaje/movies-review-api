<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Africred Movie API",
 *     version="1.0.0",
 *     description="Africred Movie API Docs",
 *     @OA\Contact(
 *         email="amowogbajegideon@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Sanctum"
 * )
 */


class SwaggerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Register a new user",
     *     description="Registers a new user and returns a success message or validation error.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Gideon Amowogbaje"),
     *             @OA\Property(property="email", type="string", format="email", example="amowogbajegigisef@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Goldengide")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Registration successful. Awaiting admin approval."),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\AdditionalProperties(type="array",
     *                     @OA\Items(type="string", example="The email field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Registration failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Registration failed. Please try again later."),
     *             @OA\Property(property="errors", type="array", @OA\Items())
     *         )
     *     )
     * )
     */

    public function registerEndpoint() {}

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User Login",
     *     description="Logs in a user and returns a token with user details.",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="amowogbajegigisef@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="Goldengide")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Login successful"),
     *             @OA\Property(property="token", type="string", example="2|X9bEPMx35QkfHYSL6ebxZxZTQArEaeyTRDVqBEPv6955a685"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=7),
     *                     @OA\Property(property="name", type="string", example="Gideon Amowogbaje"),
     *                     @OA\Property(property="email", type="string", example="amowogbajegigisef@gmail.com"),
     *                     @OA\Property(property="is_approved", type="boolean", example=false)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User account not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="User account not found"),
     *             @OA\Property(property="errors", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Login failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Login failed. Please try again."),
     *             @OA\Property(property="errors", type="array", @OA\Items())
     *         )
     *     )
     * )
     */
    public function loginEndpoint() {}


    /**
     * @OA\Get(
     *     path="/api/v1/movies",
     *     summary="Get a list of movies",
     *     description="Retrieves a paginated list of movies with their details. Requires authentication.",
     *     tags={"Movies"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search movies by title or genre",
     *         required=false,
     *         @OA\Schema(type="string", example="Science Fiction")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movies retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movies retrieved"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Inception"),
     *                     @OA\Property(property="description", type="string", example="A mind-bending thriller about dreams within dreams."),
     *                     @OA\Property(property="thumbnail", type="string", format="url", example="https://example.com/inception.jpg"),
     *                     @OA\Property(property="video_url", type="string", format="url", example="https://www.youtube.com/shorts/-vi0ScxVxoQ"),
     *                     @OA\Property(property="release_date", type="string", format="date", example="2010-07-16"),
     *                     @OA\Property(property="genre", type="string", example="Science Fiction"),
     *                     @OA\Property(property="rating", type="object",
     *                         @OA\Property(property="average", type="number", format="float", example=0),
     *                         @OA\Property(property="count", type="integer", example=0)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve movies",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve movies. Please try again later.")
     *         )
     *     )
     * )
     */

    public function retreiveMoviesEndpoints() {}


    /**
     * @OA\Post(
     *     path="/api/v1/admin/movies",
     *     summary="Create a Movie",
     *     security={{ "bearerAuth":{} }},
     *     description="Creates a new movie and returns the created movie details.",
     *     tags={"Movies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "thumbnail", "release_date", "genre"},
     *             @OA\Property(property="title", type="string", example="Inception Geeno"),
     *             @OA\Property(property="description", type="string", example="A mind-bending thriller about dreams within dreams."),
     *             @OA\Property(property="thumbnail", type="string", format="url", example="https://example.com/inception.jpg"),
     *             @OA\Property(property="video_url", type="string", format="url", example="https://www.youtube.com/shorts/-vi0ScxVxoQ"),
     *             @OA\Property(property="release_date", type="string", format="date", example="2010-07-16"),
     *             @OA\Property(property="genre", type="string", example="Science Fiction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Movie created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movie created"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=4),
     *                 @OA\Property(property="title", type="string", example="Inception Geeno"),
     *                 @OA\Property(property="description", type="string", example="A mind-bending thriller about dreams within dreams."),
     *                 @OA\Property(property="thumbnail", type="string", format="url", example="https://example.com/inception.jpg"),
     *                 @OA\Property(property="video_url", type="string", format="url", example="https://www.youtube.com/shorts/-vi0ScxVxoQ"),
     *                 @OA\Property(property="release_date", type="string", format="date", example="2010-07-16"),
     *                 @OA\Property(property="genre", type="string", example="Science Fiction"),
     *                 @OA\Property(property="rating", type="object",
     *                     @OA\Property(property="average", type="number", format="float", example=0),
     *                     @OA\Property(property="count", type="integer", example=0)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to create movie",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to create movie. Please try again."),
     *             @OA\Property(property="errors", type="array", @OA\Items())
     *         )
     *     )
     * )
     */

    public function createMoviesEndpointDocs() {}
    /**
     * @OA\Put(
     *     path="/api/v1/admin/movies/:id",
     *     summary="Update a movie",
     *     description="Updates an existing movie record.",
     *     tags={"Movies"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Movie ID",
     *         @OA\Schema(type="integer", example=4)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "thumbnail", "release_date", "genre"},
     *             @OA\Property(property="title", type="string", example="Inception Geeno Updated"),
     *             @OA\Property(property="description", type="string", example="An updated description."),
     *             @OA\Property(property="thumbnail", type="string", format="url", example="https://example.com/inception_updated.jpg"),
     *             @OA\Property(property="video_url", type="string", format="url", example="https://www.youtube.com/shorts/-vi0ScxVxoQ"),
     *             @OA\Property(property="release_date", type="string", format="date", example="2010-07-16"),
     *             @OA\Property(property="genre", type="string", example="Science Fiction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movie updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=4),
     *                 @OA\Property(property="title", type="string", example="Inception Geeno Updated"),
     *                 @OA\Property(property="description", type="string", example="An updated description."),
     *                 @OA\Property(property="thumbnail", type="string", example="https://example.com/inception_updated.jpg"),
     *                 @OA\Property(property="video_url", type="string", example="https://www.youtube.com/shorts/-vi0ScxVxoQ"),
     *                 @OA\Property(property="release_date", type="string", example="2010-07-16"),
     *                 @OA\Property(property="genre", type="string", example="Science Fiction")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update movie",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to update movie. Please try again.")
     *         )
     *     )
     * )
     */

    public function updateMoviesEndpointDocs() {}


    /**
     * @OA\Get(
     *     path="/api/v1/movies/:id",
     *     summary="Show Movie Details",
     *     description="Retrieve details of a specific movie along with reviews. Requires authentication.",
     *     tags={"Movies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Movie ID",
     *         @OA\Schema(type="integer", example=4)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movie retrieved"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="movie", type="object",
     *                     @OA\Property(property="id", type="integer", example=4),
     *                     @OA\Property(property="title", type="string", example="Inception Geeno"),
     *                     @OA\Property(property="description", type="string", example="A mind-bending thriller about dreams within dreams."),
     *                     @OA\Property(property="thumbnail", type="string", format="url", example="https://example.com/inception.jpg"),
     *                     @OA\Property(property="video_url", type="string", format="url", example="https://www.youtube.com/shorts/-vi0ScxVxoQ"),
     *                     @OA\Property(property="release_date", type="string", format="date", example="2010-07-16"),
     *                     @OA\Property(property="genre", type="string", example="Science Fiction"),
     *                     @OA\Property(property="rating", type="object",
     *                         @OA\Property(property="average", type="number", format="float", example=0),
     *                         @OA\Property(property="count", type="integer", example=0)
     *                     )
     *                 ),
     *                 @OA\Property(property="reviews", type="array", @OA\Items(type="object"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Movie not found")
     *         )
     *     )
     * )
     */
    public function showMoviesEndpointDocs() {}


    /**
     * @OA\Delete(
     *     path="/api/v1/admin/movies/:id",
     *     summary="Delete a movie",
     *     description="Deletes a specific movie by its ID.",
     *     tags={"Movies"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the movie to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Movie deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Movie deleted successfully"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Movie not found"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete movie",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to delete movie. Please try again."),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     )
     * )
     */

    public function deleteMoviesEndpointDocs() {}


    /**
     * @OA\Post(
     *     path="/api/v1/movies/:id/reviews",
     *     summary="Submit a Review for a Movie",
     *     description="Submit a rating and comment for a specific movie. Requires authentication.",
     *     tags={"Movies"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Movie ID",
     *         @OA\Schema(type="integer", example=4)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"rating", "comment"},
     *                 @OA\Property(property="rating", type="integer", example=4),
     *                 @OA\Property(property="comment", type="string", example="Good movie")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review submitted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Review submitted"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="rating", type="integer", example=4),
     *                 @OA\Property(property="comment", type="string", example="Good movie"),
     *                 @OA\Property(property="user", type="string", example="Baby Witting"),
     *                 @OA\Property(property="created_at", type="string", example="1 second ago")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error - Invalid request data",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Error"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="rating", type="array", @OA\Items(type="string", example="The rating field is required.")),
     *                 @OA\Property(property="comment", type="array", @OA\Items(type="string", example="The comment field is required."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Movie not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Movie not found")
     *         )
     *     )
     * )
     */
    public function makeReviewsEndpoint() {}


    /**
     * @OA\Post(
     *     path="/api/v1/admin/users/:id/approve",
     *     summary="Approve a user",
     *     description="Approves a user by setting `is_approved` to true. Requires admin authorization.",
     *     tags={"Admin"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User approved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User approved successfully"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid or missing token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized - User lacks permission",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="You are not authorized to approve users")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Unexpected error or database failure",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred")
     *         )
     *     )
     * )
     */

    public function adminApproveUserEndpoint() {}
}
