<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]
        );

        $user = User::create([
            'name'=> $request['name'],
            'email'=> $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        return response()->json(['token' => $user->createToken('auth_token')->plainTextToken], 200);
}
public function login(Request $request){
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password) ){
            throw ValidationException::withMessages(['email' => ['Invalid credentials']]);
        }

        return response()->json(['token' => $user->createToken('auth_token')->plainTextToken], 200);
}

public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
}
}
