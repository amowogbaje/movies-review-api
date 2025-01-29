<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approveUser(User $user)
    {
        // Gate::authorize('approve-users');
        
        $user->update(['is_approved' => true]);
        return $this->success('User approved successfully');
    }
}
