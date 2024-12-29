<?php

namespace App\Modules\CoreModule\Jobs\User;

use App\Helpers\DateBetween;
use App\Models\User;
use InnoAya\Mojura\Core\Job;

class IndexUserJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly array $payload) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query = User::with('role')
            ->when($this->payload['status'], fn ($query) => $query->where('status', $this->payload['status']))
            ->when($this->payload['role_id'], fn ($query) => $query->where('role_id', $this->payload['role_id']));

        $query = DateBetween::dateBetween($query, $this->payload['dateBetween']);

        return $query->purifySortingQuery($this->payload['order'], $this->payload['sortableFields'])->search($this->payload['searchableFields'], $this->payload['search'])->cleanPaginate($this->payload['perPage'], $this->payload['page']);
    }
}
