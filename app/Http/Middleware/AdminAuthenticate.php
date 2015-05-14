<?php namespace App\Http\Middleware;

use Closure;
use Entrust;

class AdminAuthenticate {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if(!Entrust::hasRole('admin')){
            if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->guest('auth/login');
			}
        }
		return $next($request);
	}

}
