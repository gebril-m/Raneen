<?php

namespace App\ProductFilter;
use Closure;

class Filter{
   
    public function handle($request,Closure $next)
    {
        if (!request()->has('filter')) {
            return $next($request);
        }
        
        $builder = $next($request);
        $filters = explode(',',request('filter'));

        foreach($filters as $attribute) {
            $builder->orWhere('description', 'LIKE', "'%".$attribute."%'");
        }
        // $builder = $builder->toSql();
        // dd($builder);
        return $builder;
    }
}