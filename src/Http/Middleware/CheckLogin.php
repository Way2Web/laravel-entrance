<?php

namespace IntoTheSource\Entrance\Http\Middleware;

/**
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com>
 */

use Closure;
use Auth;

class CheckLogin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (\Auth::check()) {
            return $next($request);
        }
        $request->session()->put('error', 'U moet eerst inloggen om de pagina in te zien.');
        return \Redirect::route('login.index');
    }
}