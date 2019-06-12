<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        BaseException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  Exception  $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Exception  $exception
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'code' => $exception->getStatusCode(),
                'message' => '接口地址错误'
            ], $exception->getStatusCode(), $exception->getHeaders(), JSON_UNESCAPED_UNICODE);
        } else if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'code' => $exception->getStatusCode(),
                'message' => '不允许的请求方法'
            ], $exception->getStatusCode(), $exception->getHeaders(), JSON_UNESCAPED_UNICODE);
        } else if ($exception instanceof BaseException) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 200, [], JSON_UNESCAPED_UNICODE);
        } else if ($exception->getCode() != 0) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], 200, [], JSON_UNESCAPED_UNICODE);
        }

        \Log::error($exception);

        return response()->json([
            'code' => 500,
            'message' => app()->environment('production') ? '系统错误' : $exception->getMessage()
        ], 500, [], JSON_UNESCAPED_UNICODE);
    }
}
