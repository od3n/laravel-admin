<?php

namespace Encore\Admin\Middleware;

use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperationLog
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (Admin::user()) {

            $log = [
                'user_id' => Admin::user()->id,
                'path'    => $request->path(),
                'method'  => $request->method(),
                'ip'      => $request->getClientIp(),
                'input'   => json_encode($request->input()),
            ];

            \Encore\Admin\Auth\Database\OperationLog::create($log);

        }

        return $next($request);
    }
}
