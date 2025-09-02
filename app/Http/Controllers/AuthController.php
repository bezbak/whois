<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'name'     => ['required','string','max:255'],
            'email'    => ['required','email','unique:users,email'],
            'password' => ['required','string','min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => ['id'=>$user->id,'name'=>$user->name,'email'=>$user->email],
        ], 201);
    }

    public function login(Request $r)
    {
        $data = $r->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message'=>'Invalid credentials'], 422);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => ['id'=>$user->id,'name'=>$user->name,'email'=>$user->email],
        ]);
    }

    public function logout(Request $r)
    {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }
}
