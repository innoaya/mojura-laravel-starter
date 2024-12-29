<?php

namespace App\Http\Middleware;

use App\Enums\UserStatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UserCheckMiddleware
{
    /**
     * Handle an incoming request and outgoing response
     * When a user requests data with token, first check that user is active and unlocked.
     * User is locked after n times login set in config with wrong password that is implemented in login job,.
     *
     * @author aungkyawminn
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user->status == UserStatusEnum::INACTIVE->value) {
            // Restrict access
            return response('Your account is Inactive.', 403);
        }

        $username = $user->username;
        $loginFailuresKey = 'login_failures_'.$username;

        $loginFailures = Cache::get($loginFailuresKey, 0);

        if ($loginFailures >= config('custom.setting.max_login_fails')) {
            // Restrict access
            return response('Too many login attempts. Your account is temporarily locked.', 403);
        }

        // Continue with the request
        $response = $next($request);

        // Check if the login attempt was unsuccessful
        if ($response->getStatusCode() == 401) {
            // Increment the login failures count and store it in the cache
            Cache::put($loginFailuresKey, (int) $loginFailures + 1, now()->addMinutes(config('custom.setting.failed_login_retry_minutes')));
        } else {
            // Reset the login failures count on successful login
            Cache::forget($loginFailuresKey);
        }

        return $response;
    }
}
