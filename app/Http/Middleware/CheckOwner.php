<?php

namespace App\Http\Middleware;

use Closure;

class CheckOwner
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->building->user_id == $request->user()->id) {
            return $next($request);
        }

        return response()->json([
            'errorCode' => 403,
            'error' => 'Not allowed',
        ], 403);
    }
}
