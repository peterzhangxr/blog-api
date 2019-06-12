<?php


namespace App\Http\Requests\Auth;


use App\Http\Requests\Request;

class LoginRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'string|required',
            'password' => 'string|required'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '请输入用户名/手机号/邮箱',
            'password.required' => '请输入密码'
        ];
    }

}
