<?php

namespace App\ProductFilter;
use Closure;

class Show{
   
    public function handle($request,Closure $next)
    {
        if (!request()->has('show')) {
            return $next($request);
        }
        
        $builder = $next($request);
        return $builder->take(request('show'));
    }
}