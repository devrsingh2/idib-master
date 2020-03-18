<?php

namespace App\Http\Middleware;

use Closure;

// Custom uistacks
class AdminMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
//        dd(auth()->user());
        if (isset(auth()->user()->isAdmin) && auth()->user()->isAdmin == 1) {
            return $next($request);
        }
        return redirect('/')->with('error','You have no admin access');
        /*if (auth()->check()) {
            if ($request->user()->isAdmin != '1') {
                abort('403', 'Unauthorized action.');
            }
        } else {
            return redirect( 'login');
        }
        return $next($request);*/
    }

}