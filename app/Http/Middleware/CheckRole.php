<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if($request->user() === null) {
            return response("Insufficient Permission", 401);
        }
        $actions = $request->route()->getAction();

        $role = isset($actions['role']) ? $actions['role'] : null;
        
        foreach ($role as $user_role)
        {
            if($request->user()->hasRole($user_role)){
                return $next($request);
            }
        }

        return response("Insufficient Permission", 401);
    }
}
