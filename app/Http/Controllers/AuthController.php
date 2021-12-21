<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields =  $request->validate([
           'name' => 'required|string',
           'email' => 'required|string|unique:users,email',
           'password' => 'required|string|confirmed'
        ]);

        $user = new User;
        $user->name = $fields['name'];
        $user->email = $fields['email'];
        $user->password = bcrypt($fields['password']);
        $user->save();

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return \response($response, 201);
    }
}
