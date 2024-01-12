<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
class EmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            $userId = Session::get('emp_id');
            $role = DB::table('tbl_user_role')
            ->where('user_id',$userId)
            ->first('role_id');
            if($role->role_id != 2){
                return redirect()->back()->with('error','You are not authenticated to login with this Url');
            }
        }
        return $next($request);
    }
}
