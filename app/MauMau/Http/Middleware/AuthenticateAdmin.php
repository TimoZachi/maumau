<?php
namespace MauMau\Http\Middleware;

use Closure;
use Auth;

class AuthenticateAdmin
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null)
	{
		$guard = Auth::guard($guard);
		if($guard->guest() || !$guard->user()->isAdmin())
		{
			if($request->ajax() || $request->wantsJson()) {
				return response('Unauthorized.', 401);
			} else {
				$url = $request->url();
				return redirect(route('login') . '?redirect=' . urlencode($url));
			}
		}

		return $next($request);
	}
}