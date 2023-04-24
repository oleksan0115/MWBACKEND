<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Role;

class AdminWrite extends BaseMiddleware
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
		$role = Role::where('id', '=', $user->role_id)->first();
		
		if($role->permission == 'superadmin' || $role->permission == 'admin' || $role->permission == 'write')
		{
			return $next($request);
		}
		else
		{
			return response()->json(['data' => 'UnAuthorized']);
		}
    }
}
