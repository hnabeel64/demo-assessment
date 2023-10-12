<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserSubdomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $subdomain): Response
    {
        $checkdomains = User::where('id', auth()->user()->id)->whereHas('domains', function($q) use($subdomain){
            $q->where('domain_name', $subdomain);
        })->exists();
        if($checkdomains){
            return $next($request);
        }

        abort(404);
    }
}
