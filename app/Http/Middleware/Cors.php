<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allowedOrigins = [
            config('app.shopify_url')
        ];
        $requestOrigin = $request->headers->get('origin');
        $inArray = false;
        if ($requestOrigin) {
            foreach ($allowedOrigins as $allowedOrigin) {
                if (str_contains($requestOrigin, $allowedOrigin)) {
                    return $next($request)
                    ->header('Access-Control-Allow-Origin', $requestOrigin)
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
                    ->header('Access-Control-Allow-Credentials', 'true')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
                }
            }
        }
        
        return $next($request);
    }
}
