<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Write extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$user = JWTAuth::parseToken()->authenticate();
		
		if($user->role_id == '4')
		{
			return $next($request);
		}
		else
		{
			return response()->json(['data' => 'UnAuthorized']);
		}
    }
}
