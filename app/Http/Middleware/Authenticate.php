<?php

namespace App\Http\Middleware;

use App\Exceptions\BaseException;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure  $next
     * @return mixed
     * @throws BaseException
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (!empty($user)) {
            return $next($request);
        }

        throw new BaseException('您暂未登录，请先登录');
    }
}
