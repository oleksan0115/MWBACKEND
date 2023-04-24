<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Role;
class Admin extends BaseMiddleware
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
	
		// $user = JWTAuth::parseToken()->authenticate();
		// dd($user);
		// $role = Role::where('id', '=', $user->role_id)->first();
		// dd(session());
		if(session()->has('user_id'))
		{

			return $next($request);
		}
		else
		{
			return redirect('adminLogin');
		}
    }
}

