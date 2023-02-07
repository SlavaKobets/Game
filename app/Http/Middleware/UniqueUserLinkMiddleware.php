<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UniqueUserLinkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$request->route('uuid') || User::query()->where('link', 'LIKE', $request->route('uuid'))->doesntExist() ||
            User::query()->where('link', 'LIKE', $request->route('uuid'))
                ->where('expired_at','<=', now())->exists())
        {
            return Redirect::route('register');
        }
        return $next($request);
    }
}
