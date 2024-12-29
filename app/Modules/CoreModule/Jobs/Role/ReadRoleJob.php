<?php

namespace App\Modules\CoreModule\Jobs\Role;

use App\Models\Role;
use InnoAya\Mojura\Core\Job;

class ReadRoleJob extends Job
{
    public function __construct(private readonly int $roleId) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = Role::with('abilities')->findOrFail($this->roleId);

        return $data;
    }
}
