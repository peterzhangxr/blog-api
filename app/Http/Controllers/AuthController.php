<?php


namespace App\Http\Controllers;

use App\Exceptions\BaseException;
use App\Http\Requests\Auth\LoginRequest;
use App\Model\User;
use Illuminate\Http\JsonResponse;

/**
 * @resource Auth
 *
 * 权限相关操作
 */
class AuthController extends Controller
{

    /**
     * Api_Auth_Login 登录
     * @param LoginRequest $request
     *
     * @throws BaseException
     * @return JsonResponse
    */
    public function login(LoginRequest $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');

        $query = User::query();
        if (isValidTelephone($username)) {
            $query->where('mobile', $username);
        } else if (isValidEmail($username)) {
            $query->where('email', $username);
        } else {
            $query->where('name', $username);
        }

        $user = $query->first();
        if (!$user) {
            throw new BaseException('请输入正确的用户名/手机号/邮箱');
        }

        if (!password_verify($password, $user->password)) {
            throw new BaseException('请输入正确的密码');
        }

        $token = auth()->login($user);
        return jsonAnswer([
            'token' => $token
        ]);
    }
}
