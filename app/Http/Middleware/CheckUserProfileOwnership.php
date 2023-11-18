<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserProfileOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->profile->user_id;

        if ($userId !== auth()->user()->id) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to make this request',
            ], 401);
        }

        return $next($request);
    }
}
