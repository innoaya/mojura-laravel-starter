<?php

namespace App\Modules\CoreModule\Features\Role;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\Role\DeleteRoleJob;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class DeleteRoleFeature extends Feature
{
    public function __construct(private readonly int $roleId) {}

    /**
     * Execute the feature.
     */
    public function handle(): JsonResponse
    {
        try {
            $this->run(new DeleteRoleJob($this->roleId));
        } catch (ModelNotFoundException $e) {
            return JsonResponder::error('Branch not found', 404);
        } catch (\Exception $e) {
            return JsonResponder::error('Error deleting: '.$e->getMessage());
        }

        return JsonResponder::success('Role deleted successfully');
    }
}
