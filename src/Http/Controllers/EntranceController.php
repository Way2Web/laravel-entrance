<?php

namespace Way2Web\Entrance\Http\Controllers;

/**
 * @package Entrance
 * @author David Bikanov <dbikanov@intothesource.com>
 * @author Gertjan Roke <gjroke@intothesource.com>
 */
use App\Http\Controllers\Controller;
use Way2Web\Entrance\Models\Password_reset;
use Way2Web\Entrance\Models\User;
use Way2Web\Entrance\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class EntranceController extends Controller
{

    /**
     * Logs user in after checking inserted data.
     * @param Request $request
     * @return void
     * @author David Bikanov
     */
    public function doLogin(Request $request)
    {
        $userdata = array(
            'email'     =>  $request->email,
            'password'  =>  $request->password
        );
        
        if(\Auth::attempt($userdata, true, true))
        {
            if(config('entrance.activated')) {
                if(\Auth::user()->status != 1) {
                    // Logging the user out
                    \Auth::logout();

                    $request->session()->flash('message', 'Dit account is staat niet op active');
                    return redirect()->route('login.index');
                }
            }
            $request->session()->flash('message', 'Ingelogd');
            return redirect()->intended();
        }
        else
        {
            $request->session()->flash('message', 'E-mail of wachtwoord onjuist!');
            return redirect()->route('login.index')->withInput();
        }
    }

    /**
     * Logs user out.
     * @return void
     * @author David Bikanov
     */
    public function doLogout(Request $request)
    {
        \Auth::logout();
        $request->session()->flash('message', 'Succesvol uitgelogd');
        return redirect()->route('login.index');
    }

    /**
     * Sends a password reset e-mail to the user.
     * @param Request $request
     * @return void
     * @author David Bikanov
     */
    public function sendReset(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();
        if($user !== null)
        {
            $existingReset = Password_reset::where('email', $request->email)->first();
            if($existingReset !== null)
            {

                $existingReset->created_at = Carbon::now()->toDateTimeString();
                $existingReset->save();

                \Mail::send(config('entrance.mail.password_reset'), ['reset' => $existingReset->token], function ($m) use ($user) {
                    $m->to($user->email, $user->name)->subject('Your Password Reset!');
                });

                $request->session()->flash('message', 'Er is een e-mail met een link verzonden.');
                return redirect()->route('reset.password');

            }
            else
            {
                $passwordReset = new Password_reset();
                $passwordReset->email = $request->email;
                $passwordReset->token = $request->_token;
                $passwordReset->created_at = Carbon::now()->toDateTimeString();
                $passwordReset->save();

                \Mail::send(config('entrance.mail.password_reset'), ['reset' => $request->_token], function ($m) use ($user) {
                    $m->to($user->email, $user->name)->subject('Your Password Reset!');
                });

                $request->session()->flash('message', 'Er is een e-mail met een link verzonden.');
                return redirect()->route('reset.password');
            }
        }
        else
        {

            $request->session()->flash('message', 'Er bestaat geen gebruiker met het ingevoerde e-mail adres.');
            return redirect()->route('reset.password');
        }
    }

    /**
     * Resets the users password.
     * @param Request $request
     * @return void
     * @author David Bikanov
     */
    public function doReset(Request $request)
    {
        $existingReset = Password_reset::where('email', $request->email)
                                        ->where('token', $request->token)
                                        ->first();

        if ($existingReset !== null)
        {
            if ($request->password === $request->input('repeat-password'))
            {
                $user = User::where('email',$request->email)->first();
                $user->password = bcrypt($request->password);
                $user->save();

                $existingReset->delete();

                return redirect()->route('success');
            }
            else
            {
                $request->session()->flash('message', 'De ingevoerde wachtwoorden komen niet overeen.');
                return back()->withInput();
            }
        }
        else
        {
            $request->session()->flash('message', 'Het ingevoerde e-mail adres is onjuist.');
            return back()->withInput($request->except('email'));
        }
    }

    /**
     * Register the given input
     * 
     * @param RegisterRequest $request
     * @return redirect
     */
    public function doRegister(RegisterRequest $request)
    {
        // Encrypt the password
        $request['password'] = bcrypt($request->password);

        $userModel = config('entrance.classes.user_model');
        $user = $userModel::create($request->all());

        if(config('intothesource')) {
            $roleModel = config('intothesource.usermanager.default_role_model');
            $role = $roleModel::where('name', config('intothesource.usermanager.default_role'))->firstOrFail()->id;
            $user->roles()->attach([$role]);
        }

        $request->session()->flash('message', 'Succesvol geregistreerd');
        return Redirect()->route('register');
    }
}
