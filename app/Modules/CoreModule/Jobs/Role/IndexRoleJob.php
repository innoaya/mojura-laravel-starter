<?php

namespace App\Modules\CoreModule\Jobs\Role;

use App\Models\Role;
use InnoAya\Mojura\Core\Job;

class IndexRoleJob extends Job
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
        $query = Role::purifySortingQuery($this->payload['order'], $this->payload['sortableFields']);

        return $query->search($this->payload['searchableFields'], $this->payload['search'])->cleanPaginate($this->payload['perPage'], $this->payload['page']);
    }
}
