<?php

namespace App\Http\Middleware;

use Closure;

class DepartmentAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!isSuperAdminOrAdminOrDepartmentAdmin()) {

            session()->flash('toast', toastMessage('You are not allowed to view this page', 'error'));

            return redirect('/home');
        }

        return $next($request);
    }
}
