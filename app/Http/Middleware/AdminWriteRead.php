
<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Role;

class AdminWriteRead extends BaseMiddleware
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
		
		if($user->role_id == 'admin' || $user->role_id == 'write' || $user->role_id == 'read')
		{
			return $next($request);
		}
		else
		{
			return response()->json(['data' => 'UnAuthorized']);
		}
    }
}
