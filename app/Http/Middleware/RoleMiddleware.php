<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Check if user has the required role
        if ($user->role !== $role) {
            // Redirect to appropriate dashboard based on user's actual role
            return match($user->role) {
                'student' => redirect()->route('student.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'company' => redirect()->route('company.dashboard'),
                default => redirect()->route('dashboard')
            };
        }

        return $next($request);
    }
}