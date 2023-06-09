<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RequestTimer
{
    /**
     * Handle an incoming request.
     * @param Request                       $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $timer = microtime(true);

        /** @var JsonResponse  $response */
        $response = $next($request);

        $content = json_decode($response->getContent(), true);
        if ($content) {
            $content['time'] = (microtime(true) - $timer) . ' сек.';
            $response->setContent(json_encode($content));
        }

        return $response;
    }
}
