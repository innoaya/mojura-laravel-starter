<?php

namespace App\Modules\CoreModule\Features\Role;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Http\Requests\UpdateRoleRequest;
use App\Modules\CoreModule\Jobs\Role\UpdateRoleJob;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use InnoAya\Mojura\Core\Feature;

class UpdateRoleFeature extends Feature
{
    public function __construct(private readonly int $roleId) {}

    /**
     * Execute the feature.
     */
    public function handle(UpdateRoleRequest $request): JsonResponse
    {

        try {
            $role = $this->run(new UpdateRoleJob($request->validated(), $this->roleId));
        } catch (ModelNotFoundException $e) {
            return JsonResponder::error('Role not found', 404);
        } catch (\Exception $e) {
            return JsonResponder::error('Error updating: '.$e->getMessage());
        }

        return JsonResponder::success('Role updated successfully', $role);
    }
}
