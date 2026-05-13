<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppLanguage
{

    public function handle(Request $request, Closure $next): Response
    {
        $request->header('Accept-Language') == 'en' ? app()->setLocale('en') : app()->setLocale('ar');

        return $next($request);
    }
}
