<?php

namespace App\Modules\CoreModule\Features;

use App\Helpers\JsonResponder;
use App\Modules\CoreModule\Jobs\GetOptionDataJob;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use InnoAya\Mojura\Core\Feature;

class GetOptionDataFeature extends Feature
{
    public function __construct(private readonly string $key) {}

    /**
     * Execute the feature.
     */
    public function handle(Request $request): JsonResponse
    {
        try {
            $page = $request->input('current_page');
            $perPage = $request->input('per_page');

            $payload = [
                'page' => $page,
                'perPage' => $perPage,
                'key' => $this->key,
            ];

            $options = $this->run(new GetOptionDataJob($payload));

            return JsonResponder::success('Data has been successfully retrieved', $options['data'], Arr::only($options, ['current_page', 'per_page', 'total']));

        } catch (ErrorException $iae) {
            return JsonResponder::notFound('Option not found');
        } catch (\Exception $e) {
            return JsonResponder::error($e->getMessage(), 500);
        }
    }
}
