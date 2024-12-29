<?php

namespace App\Modules\CoreModule\Features\Role;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Http\Requests\CreateRoleRequest;
use App\Modules\CoreModule\Jobs\Role\CreateRoleJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use InnoAya\Mojura\Core\Feature;

class CreateRoleFeature extends Feature
{
    /**
     * Execute the feature.
     */
    public function handle(CreateRoleRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $role = $this->run(CreateRoleJob::class, ['payload' => $request->validated()]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return JsonResponder::error('Error creating role: '.$e->getMessage());
        }

        return JsonResponder::success('Role has been successfully created', $role);
    }
}
