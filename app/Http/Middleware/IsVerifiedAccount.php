<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class IsVerifiedAccount
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

        # if user authed
        if($request->user()){

            if ( !$request->user()->hasVerifiedEmail() ) {
                
                return $request->expectsJson()
                        ? abort(403, 'Your email address is not verified.')
                        : Redirect::route('web.account.verify.show');
            }
        }

        return $next($request);
        
    }
}

