<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    public function approveUser(User $user)
    {
        try {
            Gate::authorize('approve-users');

            $user->update(['is_approved' => true]);

            return $this->success('User approved successfully');
        } catch (AuthorizationException $e) {
            Log::error("Authorization failed: {$e->getMessage()}");
            return $this->error('You are not authorized to approve users', [], 403);
        } catch (ModelNotFoundException $e) {
            Log::error("User not found: {$e->getMessage()}");
            return $this->error('User not found', [], 404);
        } catch (QueryException $e) {
            Log::error("Database error during approval: {$e->getMessage()}");
            return $this->error('Failed to update user approval status', [], 500);
        } catch (Exception $e) {
            Log::error("Unexpected error in approval: {$e->getMessage()}");
            return $this->error('An unexpected error occurred', [], 500);
        }
    }
}
