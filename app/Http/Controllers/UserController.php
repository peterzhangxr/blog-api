<?php


namespace App\Http\Controllers;


use App\Http\Transforms\UserTransform;
use Illuminate\Http\JsonResponse;

/**
 * @resource User
 *
 * 权限相关操作
 */
class UserController extends Controller
{

    /**
     * Api_User_Profile 用户详情
     *
     * @return JsonResponse
    */
    public function profile()
    {
        return jsonAnswer(UserTransform::make($this->loginUser));
    }

}
