<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function login(LoginRequest $request) 
    {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return abort(401, 'Invalid credentials');
        }

        $token = $user->createToken(Uuid::uuid4(), ['manage:account']);

        return [
            "message" => "Authentication successful",
            "token" => $token->plainTextToken,
        ];
    }

    public function register(RegisterRequest $request)
    {
        $exiting = User::where('email', $request->email)->count();
        if($exiting) {
            return abort('429', 'Email address already registered');
        }

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);

        return [
            "message" => "Account successfully registered",
        ];
    }
}
