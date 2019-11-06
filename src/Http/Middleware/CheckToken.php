<?php

namespace Way2Web\Entrance\Http\Middleware;

/*
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com>
 */

use Closure;
use Way2Web\Entrance\Models\Password_reset;

class CheckToken
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $reset = Password_reset::where('token', $request->token)->first();

        if ($reset !== null) {
            if ($reset->created_at->diffInHours() === 0) {
                return $next($request);
            }
            $request->session()->flash('error', 'De token is verlopen. Vraag een nieuwe link aan.');

            return \Redirect::route('reset.password');
        }
        $request->session()->flash('error', 'De token is onjuist. Vraag een nieuwe link aan of neem contact op met de beheerder als het probleem zich blijft voortdoen.');

        return \Redirect::route('reset.password');
    }
}
