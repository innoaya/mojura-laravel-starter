<?php

namespace App\Modules\CoreModule\Features\User;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Http\Requests\CreateUserRequest;
use App\Modules\CoreModule\Jobs\User\CreateUserJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class CreateUserFeature extends Feature
{
    /**
     * Execute the feature.
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function handle(CreateUserRequest $request): JsonResponse
    {
        $data = $this->run(CreateUserJob::class, ['payload' => $request->validated()]);

        return JsonResponder::created('User has been successfully created', $data);
    }
}
