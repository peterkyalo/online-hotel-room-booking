<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Customer extends Middleware
{
    protected function redirectTo(Request $request) : ?string
    {
        // if (! $request->expectsJson()) {
        //     return route('customer_login');
        // }
        return $request->expectsJson() ? null : route('customer_login');
    }
}