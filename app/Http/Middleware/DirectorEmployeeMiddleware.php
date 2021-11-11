<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DirectorEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (is_null(auth()->user()->director)) {
            return response()->json([
                'status' => false,
                'message' => __("You aren't a director"),
                'data' => new \stdClass(),
                'append' => new \stdClass(),
                'errors' => $errors ?? []
            ], 403);
        }
        return $next($request);
    }
}
