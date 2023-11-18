<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserEventOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // dd(auth()->user()->id);

        $userId = $request->event->creator_id;

        if ($userId !== auth()->user()->id) {
            return response()->json([
                'status' => 401,
                'message' => 'You are not authorized to make this request',
            ], 401);
        }

        return $next($request);
    }
}
