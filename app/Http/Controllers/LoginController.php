<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            return response()->json([
                'token' => auth()->user()->createToken('authToken')->plainTextToken
            ], 201);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
