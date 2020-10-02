<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class JwtAuthController extends Controller
{
    #register function
    public function register(Request $request){
        #this is the validate for the request
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        #validation if the request have a error
        if($validator->fails()){
            #returned in json format the error with the 400 code
            return response()->json($validator->errors()->toJson(), 400);
        }
        //call the user model and call the create function for save in the database
        User::create([
            #the data in the request
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            #call the hash methos to encode the password
            'password' => Hash::make($request->get('password')),
        ]);
        #is user created returned a json object with the 201 code
        return response()->json([
            'message'=>'created',
            "code"=>201,
            "state"=>true
        ],201);
    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
    public function logout(Request $request){
        $this->validate($request,[
            'token'=>'required'
        ]);
        try{
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success'=> true,
                'message'=>'User Logged Out'
            ]);
        }catch(JWTException $exception){
            return response()->json([
                'success'=>false,
                'message' => 'The user dont be looged'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getUser(Request $request){
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }

    } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 401);

    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 401);

    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], 500);

    }

    return response()->json(compact('user'));
    }
}
