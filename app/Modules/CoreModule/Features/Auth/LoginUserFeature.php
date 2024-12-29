<?php

namespace App\Modules\CoreModule\Features\Auth;

use App\Exceptions\UnauthorizedException;
use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Http\Requests\LoginRequest;
use App\Modules\CoreModule\Jobs\Auth\LoginUserJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class LoginUserFeature extends Feature
{
    /**
     * Execute the feature.
     */
    public function handle(LoginRequest $request): JsonResponse
    {
        try {
            $response = $this->run(new LoginUserJob($request->validated()));

            return JsonResponder::success('Logged in successfully', $response);
        } catch (UnauthorizedException $ue) {
            return JsonResponder::unauthorized('Wrong Credentials');
        }
    }
}
