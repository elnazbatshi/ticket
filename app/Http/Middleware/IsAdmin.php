<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $user = User::findOrFail(Auth::user()->id);
        $admin=$user->roles()->where('title', 'Admin')->first();
        $agent=$user->roles()->where('title', 'Agent')->first();
//      $customer=$user->roles()->where('title', 'Customer')->get();

        if ($agent!=[] || $admin!=[]) {
            return redirect()->route('admin.tickets.index');
        }
        return $next($request);
    }
}
