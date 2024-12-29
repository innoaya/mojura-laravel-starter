<?php

namespace App\Modules\CoreModule\Features\Role;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\Role\ReadRoleJob;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class ReadRoleFeature extends Feature
{
    public function __construct(private readonly int $roleId) {}

    /**
     * Execute the feature.
     *
     * @return int
     */
    public function handle(): JsonResponse
    {
        try {
            $data = $this->run(new ReadRoleJob($this->roleId));

            return JsonResponder::success('Role has been successfully retrieved', $data);
        } catch (\Exception $e) {
            return JsonResponder::error($e->getMessage(), 500);
        }
    }
}
