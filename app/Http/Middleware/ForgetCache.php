<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Services\CacheService;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ForgetCache
{
    const METHODS = [
        'store',
        'update',
        'destroy'
    ];

    /**
     * Handle an incoming request.
     * @param Request                       $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var JsonResponse  $response */
        $response = $next($request);

        $rout = explode('@', Route::currentRouteAction());
        $class_path = $rout[0];
        $action = $rout[1];
        if (in_array($action, self::METHODS)) {
            CacheService::forgetCache($class_path);
        }

        return $response;
    }
}
