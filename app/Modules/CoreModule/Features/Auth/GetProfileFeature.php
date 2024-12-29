<?php

namespace App\Modules\CoreModule\Features\Auth;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\Auth\GetProfileJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class GetProfileFeature extends Feature
{
    /**
     * Execute the feature.
     *
     * @return int
     */
    public function handle(): JsonResponse
    {
        $user = $this->run(new GetProfileJob);

        return JsonResponder::success('User profile has been retrieved successfully', $user);
    }
}
