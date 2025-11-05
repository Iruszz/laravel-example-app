<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || ! $user->is_admin) {

            if ($request->is('tickets/*/assign-agent')) {
                return ApiResponse::forbidden(
                    'Only admins can assign agents.',
                    'AGENT_ASSIGNMENT_FORBIDDEN'
                );
            }

            if ($request->is('categories') || $request->is('categories/*')) {
                return ApiResponse::forbidden(
                    'Only admins can access categories.',
                    'CATEGORY_FORBIDDEN'
                );
            }

            return ApiResponse::forbidden('You are not authorized.', 'FORBIDDEN');
        }

        return $next($request);
    }
}
