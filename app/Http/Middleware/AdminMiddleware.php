<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user_id = Session::get('id');
            $role = DB::table('tbl_user_role')
            ->where('id', $user_id)
            ->first('role_id');
            if ($role->role_id != 1) {
                return redirect()->back()->with('error', 'You are not authenticated to login with this Url');
            }
        }
        return $next($request);
    }
}
