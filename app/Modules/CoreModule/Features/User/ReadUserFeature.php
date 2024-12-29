<?php

namespace App\Modules\CoreModule\Features\User;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\User\ReadUserJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class ReadUserFeature extends Feature
{
    public function __construct(private readonly int $userId) {}

    /**
     * Execute the feature.
     */
    public function handle(): JsonResponse
    {
        $user = $this->run(new ReadUserJob($this->userId));

        return JsonResponder::success('User has been successfully retrieved', $user);
    }
}
