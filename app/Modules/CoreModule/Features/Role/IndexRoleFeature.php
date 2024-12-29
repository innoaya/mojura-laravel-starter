<?php

namespace App\Modules\CoreModule\Features\Role;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\Role\IndexRoleJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use InnoAya\Mojura\Core\Feature;

class IndexRoleFeature extends Feature
{
    /**
     * Execute the feature.
     */
    public function handle(Request $request): JsonResponse
    {
        $page = $request->query('current_page');
        $perPage = $request->query('per_page');
        $search = $request->query('search');
        $order = $request->query('order') ?? [['column' => 'created_at', 'order' => 'desc']];

        $searchableFields = ['id', 'name', 'description'];
        $sortableFields = [
            'id', 'name', 'description', 'created_at',
        ];

        $payload = [
            'page' => $page,
            'perPage' => $perPage,
            'search' => $search,
            'order' => $order,
            'searchableFields' => $searchableFields,
            'sortableFields' => $sortableFields,
        ];

        $data = $this->run(new IndexRoleJob($payload));

        return JsonResponder::success('Roles have been successfully retrieved', $data['data'], Arr::only($data, ['current_page', 'per_page', 'total']));
    }
}
