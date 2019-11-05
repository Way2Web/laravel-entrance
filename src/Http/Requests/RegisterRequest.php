<?php

namespace Way2Web\Entrance\Http\Requests;

use App\Http\Requests\Request;
use Config;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|confirmed|min:'.config('entrance.password_length').'|max:255',
        ];
    }
}
