<?php

namespace App\Http\Middleware;

use App\Helpers\JsonResponder;
use App\Models\Ability;
use App\Models\RoleAbility;
use Closure;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Contracts\Auth\Factory as Auth;

class Authorize
{
    // protected $auth;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // this is for handling authorization for route
        $action = array_slice(func_get_args(), 2)[0]; // get first parameter from middleware
        $subject = array_slice(func_get_args(), 2)[1]; // get second parameter from middleware
        $abilityId = Ability::where('action', $action)
            ->where('subject', $subject)
            ->value('id');

        $roleId = Auth::user()->role_id;

        if (! RoleAbility::where('role_id', $roleId)->where('ability_id', $abilityId)->exists()) {
            return JsonResponder::forbidden('You has no permission.');
        }

        return $next($request);
    }
}
