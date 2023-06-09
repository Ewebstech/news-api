<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        try{
            
            $fields = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed'
            ]);
    
            $user = User::create([
                'name' => $fields['name'],
                'email' => $fields['email'],
                'password' => bcrypt($fields['password'])
            ]);
    
            $response = [
                'status' => true,
                'message' => 'Registration Successful',
                'data' => $user
            ];
    
            return response($response, 201);

        } catch(Exception $e){
            $response = [
                'status' => false,
                'message' => "Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}"
            ];

            return response($response, 500);
        }
        
    }

    public function login(Request $request) {
        try {
            $fields = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string'
            ]);
    
            // Check email
            $user = User::where('email', $fields['email'])->first();
    
            // Check password
            if(!$user || !Hash::check($fields['password'], $user->password)) {
                return response([
                    'status' => false,
                    'message' => 'Wrong Credentials'
                ], 401);
            }
    
            $token = $user->createToken('myapptoken')->plainTextToken;

            $user->access_token = $token;
            $response = [
                'status' => true,
                'message' => 'Login Successful',
                'data' => $user
            ];
    
            return response($response, 200);

        }catch(Exception $e){
            $response = [
                'status' => false,
                'message' => "Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}"
            ];

            return response($response, 500);
        }
       
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'status' => true,
            'message' => 'Logged out'
        ];
    }
}