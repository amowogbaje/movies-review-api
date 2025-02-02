<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Notifications\NewUserRegisteredNotification;
use Exception;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create($validated);

            $admins = User::where('is_admin', true)->get();

            foreach ($admins as $admin) {
                $admin->notify(new NewUserRegisteredNotification($user));
            }


            return $this->success('Registration successful. Awaiting admin approval.', "", Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation Error', $e->errors(), 422);
        } catch (Exception $e) {
            Log::error('Registration Error: ' . $e->getMessage());
            return $this->error('Registration failed. Please try again later.', [], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8',
            ]);
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error('Invalid credentials', [], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();

            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->authSuccess('Login successful', $token, [
                'user' => $user->only('id', 'name', 'email', 'is_approved', 'is_admin')
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation Error', $e->errors(), 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Login Error - User not found: ' . $e->getMessage());
            return $this->error('User account not found', [], 404);
        } catch (Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            return $this->error('Login failed. Please try again.', [], 500);
        }
    }
}
