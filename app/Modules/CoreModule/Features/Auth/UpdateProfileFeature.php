<?php

namespace App\Modules\CoreModule\Features\Auth;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Http\Requests\UpdateUserRequest;
use App\Modules\CoreModule\Jobs\User\UpdateUserJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class UpdateProfileFeature extends Feature
{
    /**
     * Execute the feature.
     */
    public function handle(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->run(new UpdateUserJob($request->validated(), $request->user()->id));

        return JsonResponder::success('Profile information updated successfully', $user);
    }
}
