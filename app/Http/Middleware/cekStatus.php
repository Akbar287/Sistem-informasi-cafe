<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class cekStatus
{
    public function handle($request, Closure $next)
    {
        if(Auth::user()->isActive == 1){
            return $next($request);
        } else {
            abort(401, 'This action is unauthorized.');
        }
    }
}
