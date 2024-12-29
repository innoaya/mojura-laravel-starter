<?php

namespace App\Modules\CoreModule\Features\Auth;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\Auth\LogoutUserJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InnoAya\Mojura\Core\Feature;

class LogoutUserFeature extends Feature
{
    /**
     * Execute the feature.
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function handle(Request $request): JsonResponse
    {
        $this->run(new LogoutUserJob([
            'accessToken' => $request->bearerToken(),
            'logOutAllSessions' => $request->input('logout_all_sessions', false),
        ]));

        return JsonResponder::success('Logged out successfully');
    }
}
