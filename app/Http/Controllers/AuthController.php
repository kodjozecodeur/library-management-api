<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{


    //register function
    public function register(RegisterRequest $request)
    {
        $fields = $request->validated();
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);
        // Sanctum token
        $token = $user->createToken('library_api_token');

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
        ], 201);
    }
    //login function
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            Log::warning('Failed login attempt', [
                'email' => $fields['email'],
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            Hash::check('dummy-password', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('library_api_token');
        Log::info('User logged in', ['user_id' => $user->id, 'ip' => $request->ip()]);

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
        ], 200);
    }
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'Not authenticated'], 401);
            }

            // Delete current token only
            $request->user()->currentAccessToken()->delete();
            // Or delete all tokens: $request->user()->tokens()->delete();

            Log::info('User logged out', ['user_id' => $user->id]);

            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json(['message' => 'Logout failed'], 500);
        }
    }
}

