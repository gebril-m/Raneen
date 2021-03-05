<?php

namespace App\ProductFilter;
use Closure;

class Sort{
   
    public function handle($request,Closure $next)
    {
        if (!request()->has('sort')) {
            return $next($request);
        }
        
        $builder = $next($request);
        return $builder->orderBy('id',request("sort"));
    }
}