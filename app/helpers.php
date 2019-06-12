<?php

/**
 * Created by PhpStorm.
 * User: peterzhang
 * Date: 2017/8/2
 * Time: 下午3:42
 */

if ( ! function_exists('jsonAnswer')) {

    /**
     * 定义全局的返回,请求成功的返回
     * jsonAnswer($data)
     * jsonAnswer($message)
     * jsonAnswer($data, $message)
     * @return Illuminate\Http\JsonResponse
     *
     */
    function jsonAnswer()
    {
        $message = '';
        $data = [];
        $num = func_num_args();
        if ($num >= 2) {
            $message = func_get_arg(1);
            $data = func_get_arg(0);
        } elseif ($num >= 1) {
            $arg = func_get_arg(0);
            if ( ! is_string($arg)) {
                $data = $arg;
            } else {
                $message = $arg;
            }
        }

        $response = [
            'code'    => 200,
            'message' => $message ?: '请求成功',
            'data'    => $data
        ];

        if (empty($data)) {
            unset($response['data']);
        }

        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE);
    }
}



if ( ! function_exists('getUniqueID')) {

    /**
     * 获取唯一的ID
     *
     * @param $len
     *
     * @return string
     */

    function getUniqueID($len = 8)
    {

        $hex = md5(env('APP_KEY').uniqid("", true));

        $pack = pack('H*', $hex);
        $tmp = base64_encode($pack);

        $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

        $len = max(4, min(128, $len));

        while (strlen($uid) < $len) {
            $uid .= getUniqueID(22);
        }

        return substr($uid, 0, $len);
    }
}

if ( ! function_exists('isValidTelephone')) {
    /**
     * 验证是否有效的手机号
     *
     * @param string $telephone
     *
     * @return boolean
     *
     */
    function isValidTelephone($telephone)
    {
        return preg_match('/^1[345789][0-9]{9}$/', $telephone);
    }
}

if ( ! function_exists('isValidEmail')) {
    /**
     * 验证邮箱地址是否有效
     *
     * @param string $email
     *
     * @return boolean
     *
     */
    function isValidEmail($email)
    {
        $atIndex = strrpos($email, "@");
        if ($atIndex === false) {
            return false;
        }

        $domain = substr($email, $atIndex + 1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);

        // local part length exceeded
        if ($localLen < 1 || $localLen > 64) {
            return false;
        }

        // domain part length exceeded
        if ($domainLen < 1 || $domainLen > 255) {
            return false;
        }

        // local part starts or ends with '.'
        if ($local[0] == '.' || $local[$localLen - 1] == '.') {
            return false;
        }

        // local part has two consecutive dots
        if (preg_match('/\\.\\./', $local)) {
            return false;
        }

        // character not valid in domain part
        if ( ! preg_match('/^[a-z0-9\\-\\.]+$/i', $domain)) {
            return false;
        }

        // domain part has two consecutive dots
        if (preg_match('/\\.\\./', $domain)) {
            return false;
        }

        if ( ! preg_match('/^([a-z0-9])+([a-z0-9\._-])*@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})$/i',
            $email)
        ) {
            return false;
        }

        return true;
    }

}

if ( ! function_exists('getSmsCode')) {

    /**
     * 生产验证码
     *
     * @param integer $length 默认为6
     *
     * @return string
     */
    function getSmsCode($length = 6)
    {
        $string = '0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= substr($string, mt_rand(0, strlen($string) - 1), 1);
        }

        return $code;
    }
}

if ( ! function_exists('getServerIP')) {
    function getServerIP()
    {
        if ( ! empty($_SERVER['SERVER_ADDR'])) {
            $ip = $_SERVER['SERVER_ADDR'];
        } elseif ( ! empty($_SERVER['SERVER_NAME'])) {
            $ip = gethostbyname($_SERVER['SERVER_NAME']);
        } else {
            // for php-cli(phpunit etc.)
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

if ( ! function_exists('getClientIP')) {
    function getClientIP()
    {
        if ( ! empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif ( ! empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return 'unknown';
        }
    }
}

if ( ! function_exists('getAppVersion')) {
    /**
     * 获取当前游戏客户端版本
    */
    function getAppVersion()
    {
        $version = Request::header('Version');

        if (empty($version)) {
            $version = Request::get('version', '0.0.0');
        }

        return $version;
    }
}
