<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * Logout from all guards except the specified ones
     *
     * @param array $except
     * @return void
     */
    public static function logoutOtherGuards(array $except = [])
    {
        $guards = ['admin', 'apex', 'committee', 'chapter', 'accountant'];

        foreach ($guards as $guard) {
            if (!in_array($guard, $except) && Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }
    }
}

