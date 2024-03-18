<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
//        return $request->expectsJson() ? null : route('login');

        // MODIFICATO DA ME
        if (!$request->expectsJson())
        {
            if ($request->routeIs('admin.*'))
            {
                session()->flash('fail', 'You must login first, if you are ADMIN');
                return route('admin.login');
            }
        }
    }
}
