<?php

/**
 * File name: Permissions.php
 * Last modified: 2020.05.25 at 16:25:18
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Gate;

class Permissions
{
    private $exceptNames = [
        'LaravelInstaller*',
        'LaravelUpdater*',
        'debugbar*'
    ];

    private $exceptControllers = [
        'LoginController',
        'ForgotPasswordController',
        'ResetPasswordController',
        'RegisterController',
        'PayPalController',
        'AuthController',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });

        $permission = $request->route()->getName();

        if ($this->match($request->route()) && auth()->user()->cannot($permission)) {
            if ($permission == '/') {
                return redirect(route('/'));
            }
            // } elseif ($permission == 'user.login') {
            //     return redirect(route('user.login'));
            // } elseif ($permission == 'user.login.user') {
            //     return redirect(route('user.login.user'));
            // } elseif ($permission == 'user.register') {
            //     return redirect(route('user.register'));
            // } elseif ($permission == 'user.check.register') {
            //     return redirect(route('user.check.register'));
            // } else {
            //     return redirect(route('user.index'));
            // }
            throw new UnauthorizedException(403, trans('error.permission') . ' <b>' . $permission . '</b>');
        }

        return $next($request);
    }

    private function match(\Illuminate\Routing\Route $route)
    {
        if ($route->getName() == '' || $route->getName() === null) {
            return false;
        } else {
            if (in_array(class_basename($route->getController()), $this->exceptControllers)) {
                return false;
            }
            foreach ($this->exceptNames as $except) {
                if (Str::is($except, $route->getName())) {
                    return false;
                }
            }
        }
        return true;
    }
}
