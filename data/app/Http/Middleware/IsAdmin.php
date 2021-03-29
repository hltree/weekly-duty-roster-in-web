<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authUserId = auth()->user()->getAuthIdentifier();
        $User = new User();

        if (true === $User->isAdmin($authUserId)) {
            return $next($request);
        }

        return redirect(route('home'));
    }
}
