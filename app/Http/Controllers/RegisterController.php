<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::firstOrCreate($request->validated());

        Auth::loginUsingId($user->id, $remember = true);

        return response()->json($user, 201);
    }
}
