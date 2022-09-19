<?php

namespace App\Http\Middleware;

use Closure;

class CheckIamUser
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
        $user = \Auth::user();
        if ($user->id == $request->id || $user->id == $request->user_id  
        ||  $user->hasRole('admin')||  
        $user->hasRole('master') ) {

            return $next($request);
        }
        return redirect('home');
    }
}
