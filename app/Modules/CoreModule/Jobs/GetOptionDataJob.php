<?php

namespace App\Modules\CoreModule\Jobs;

use App\Helpers\StringUtility;
use App\Models\Ability;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Role;
use App\Models\User;
use InnoAya\Mojura\Core\Job;

class GetOptionDataJob extends Job
{
    /**
     * Create a new job instance.
     */
    public function __construct(private readonly array $payload) {}

    /**
     * Execute the job.
     */
    public function handle(): array
    {

        $mapping = [
            'ability' => fn () => $this->getAbilities(),
            'user' => fn () => $this->getData(User::class, ['id', 'full_name'], $this->payload['perPage'], $this->payload['page']),
            'role' => fn () => $this->getData(Role::class, ['id', 'name'], $this->payload['perPage'], $this->payload['page']),
            'category' => fn () => $this->getData(Category::class, ['id', 'name'], $this->payload['perPage'], $this->payload['page']),
            'item' => fn () => $this->getItems($this->payload['perPage'], $this->payload['page']),
            'customer' => fn () => $this->getData(Customer::class, ['id', 'full_name'], $this->payload['perPage'], $this->payload['page']),
        ];

        return $mapping[$this->payload['key']] ? $mapping[$this->payload['key']]() : [];
    }

    private function getAbilities(): array
    {
        $abilities = Ability::select('id', 'action', 'subject')
            ->get()
            ->groupBy('subject')
            ->map(function ($item) {
                return $item->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'action' => $t->action,
                        'subject' => $t->subject,
                        'action_name' => StringUtility::snakeCaseToTitleCase($t->action),
                        'subject_name' => StringUtility::camelCaseToTitleCase($t->subject),
                    ];
                });
            })
            ->toArray();

        return ['data' => $abilities];
    }

    private function getData($model, array $columns, $perPage, $page): array
    {
        if ($perPage == 'all') {
            return ['data' => $model::select($columns)->get()->toArray()];
        }

        return $model::select($columns)->cleanPaginate($perPage, $page);
    }

    private function getItems($perPage, $page): array
    {
        $query = Item::join('categories', 'categories.id', '=', 'items.category_id')
            ->select('items.id', 'items.name', 'category_id');

        if ($perPage == 'all') {
            return ['data' => $query->get()->toArray()];
        }

        return $query->cleanPaginate($perPage, $page);
    }
}
