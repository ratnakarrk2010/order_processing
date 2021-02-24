<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;

class OMSSession {
    
    public function handle($request, Closure $next) {
        if (Session::exists("loggedInUserId"))
            return $next($request);
        else 
            return redirect('login/se');
    }
}