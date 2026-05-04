<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WebUser;

class MultiAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();
        $doctor = Auth::guard('doctor')->user();
        $patient = Auth::guard('patient')->user();
        
        $user = $admin ?? $doctor ?? $patient;
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Check if user type matches the route prefix
        $routePrefix = $request->route()->getPrefix();
        
        if ($routePrefix === 'admin' && !$admin) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }
        
        if ($routePrefix === 'doctor' && !$doctor) {
            Auth::guard('doctor')->logout();
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }
        
        if ($routePrefix === 'patient' && !$patient) {
            Auth::guard('patient')->logout();
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }
        
        return $next($request);
    }
}