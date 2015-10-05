<?php

namespace IntoTheSource\Entrance\Http\Middleware;

/**
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com>
 */

use Closure;
use App\Password_reset;
use Carbon\Carbon;

class CheckToken
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

        $reset = Password_reset::where('token', $request->token)->first();

        if($reset !== null){
            if($reset->created_at->diffInHours() === 0){
                return $next($request);
            }
            $request->session()->put('error', 'De token is verlopen. Vraag een nieuwe link aan.');
            return \Redirect::to('reset-password');
        }
        $request->session()->put('error', 'De token is onjuist. Vraag een nieuwe link aan of neem contact op met de beheerder als het probleem zich blijft voortdoen.');
        return \Redirect::to('reset-password');
    }
}