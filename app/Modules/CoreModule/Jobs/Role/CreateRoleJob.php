<?php

namespace App\Modules\CoreModule\Jobs\Role;

use App\Models\Role;
use InnoAya\Mojura\Core\Job;

class CreateRoleJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $payload) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payload = collect($this->payload);
        $createPayload = $payload->except(['ability_ids'])->toArray();
        $role = Role::create($createPayload);
        $role->abilities()->attach($payload->get('ability_ids'));

        return $role;
    }
}
