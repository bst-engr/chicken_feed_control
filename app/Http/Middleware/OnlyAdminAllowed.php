<?php namespace App\Http\Middleware;

use Closure;

class OnlyAdminAllowed {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (\Sentry::check()) {
			if(!\Sentry::getUser()->hasAccess('admin')) {

		    	if(\Sentry::getUser()->hasAccess('users')) {
		    		
		    		if ($request->ajax()) {
		                return response('Unauthorized.', 401);
		            }
		            else {
		    			return redirect('flocks');
		    		}
		    	}
		    }
		}
		return $next($request);
	}

}
