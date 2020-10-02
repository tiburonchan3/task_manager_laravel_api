<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
class JwtMiddleware extends BaseMiddleware
{
   #this function validate the user is logged with a token
    public function handle(Request $request, Closure $next)
    {
        #first validate is the token exist
        try{
            #this parsed the token and authenticate
            $user = JWTAuth::parseToken()->authenticate();
        }
        #this validate the token is expired
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            #return a message in json format
            return response()->json(['token_expired']);
        }
        #this validate the token is invalid
        catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            #return a message in json format
            return response()->json(['token_invalid']);
        }
        #this validate the token has a exeption
        catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            #return a message in json format
            return response()->json(['Unauthorized']);
        }
        #is the user is authenticate go to the next request
        return $next($request);
    }
}
