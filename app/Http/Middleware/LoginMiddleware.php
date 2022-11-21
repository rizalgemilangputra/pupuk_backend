<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class LoginMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('X-Auth-Token')) {
            $check =  User::where('token', $request->header('X-Auth-Token'))->first();

            if (!$check) {
                return response('Invalid Token.', 401);
            } else {
                return $next($request);
            }
        } else {
            return response('Token not found.', 401);
        }
    }
}
