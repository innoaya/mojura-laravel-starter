<?php

namespace App\Modules\CoreModule\Features\User;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\User\IndexUserJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use InnoAya\Mojura\Core\Feature;

class IndexUserFeature extends Feature
{
    /**
     * Execute the feature.
     */
    public function handle(Request $request): JsonResponse
    {
        try {
            $page = $request->query('current_page');
            $perPage = $request->query('per_page'); // if there is no params, all will return
            $search = $request->query('search');
            $order = $request->query('order') ?? [['column' => 'created_at', 'order' => 'desc'], ['column' => 'name', 'order' => 'asc']];

            $searchableFields = ['id', 'username', 'email', 'full_name', 'mobile_number'];
            $sortableFields = [
                'id', 'email', 'full_name', 'mobile_number', 'created_at', 'updated_at',
            ];

            /** Filters */
            $dateBetween = $request->get('date_between') ?? [];
            $roleId = $request->get('role_id');
            $status = $request->get('status');

            $payload = [
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'order' => $order,
                'searchableFields' => $searchableFields,
                'sortableFields' => $sortableFields,
                'dateBetween' => $dateBetween,
                'role_id' => $roleId,
                'status' => $status,
            ];

            $users = $this->run(new IndexUserJob($payload));

        } catch (\Exception $e) {
            return JsonResponder::error($e->getMessage(), 500);
        }

        return JsonResponder::success('Users have been successfully retrieved', $users['data'], Arr::only($users, ['current_page', 'per_page', 'total']));
    }
}
