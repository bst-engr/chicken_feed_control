<?php namespace App\Http\Middleware;

use Closure;

class SsgAuthentication {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// First make sure there is an active session
        if ( ! \Sentry::check())
        {
            if ($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect()->guest(route('sentinel.login'));
            }
        }

		return $next($request);
	}

}
