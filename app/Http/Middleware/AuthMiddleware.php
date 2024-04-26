<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if(is_null($token)){
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $t = explode(' ', $token);
        if(Hash::check(env('TOKEN_ID', 1), $t[1])) {
            return $next($request);
        }
    }
}
