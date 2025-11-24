<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $routeMiddleware = $request->route()->gatherMiddleware();

        if (!in_array("role:$role", $routeMiddleware)) {
            return $next($request);
        }

        // Kapag hindi naka-login, i-redirect sa landing page
        if (!Auth::check()) {
            return redirect()->route('landing');
        }

        // Kapag wrong role, mag abort
        if (Auth::user()->user_type !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
