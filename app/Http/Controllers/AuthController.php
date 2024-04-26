<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function me(){
        return response()->json(Auth::user());
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->messages()
            ], 422);
        }

        $user = User::where('username', $request->username)->first();
        
        if(! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Login'
            ]);
        }

        return $user->createToken('login')->plainTextToken;
    
    }

    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Success',
        ], 200);
    }
}
