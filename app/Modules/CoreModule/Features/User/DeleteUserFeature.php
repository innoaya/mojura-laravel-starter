<?php

namespace App\Modules\CoreModule\Features\User;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\User\DeleteUserJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class DeleteUserFeature extends Feature
{
    public function __construct(private readonly int $userId) {}

    /**
     * Execute the feature.
     *
     * @return int
     */
    public function handle(): JsonResponse
    {
        try {
            $this->run(new DeleteUserJob($this->userId));
        } catch (\Exception $e) {
            return JsonResponder::error('Error deleting user: '.$e->getMessage());
        }

        return JsonResponder::success('User has been successfully deleted');
    }
}
