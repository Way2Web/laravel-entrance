<?php

namespace Way2Web\Entrance\Http\Middleware;

/**
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com>
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckLogin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $request->session()->flash('error', 'U moet eerst inloggen om de pagina in te zien.');
                return redirect()->guest( route('login.index') );
            }
        }

        return $next($request);
    }
}