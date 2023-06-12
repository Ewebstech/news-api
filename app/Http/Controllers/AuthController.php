<?php

namespace App\Http\Controllers;

use Exception;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
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
    
            return $this->createdResponse('Registration Successful', $user);

        } catch(Exception $e){
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
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
            
            return $this->okResponse('Login successful', $user);

        } catch(Exception $e){
            return $this->serverErrorResponse("Exception: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}");
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