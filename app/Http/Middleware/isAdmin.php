<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class isAdmin
{

    protected $auth;
    public function __construct(Guard $auth){
        $this->auth=$auth;
    }
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->user()->type =='super_admin' ||$this->auth->user()->type == 'admin' ) {
            return $next($request);
        }
        return back()->with('permission',"Sorry, {$this->auth->user()->name} You don't have permission to access this page.");
    }
}
