<?php

namespace App\Modules\CoreModule\Jobs\Role;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use InnoAya\Mojura\Core\Job;

class DeleteRoleJob extends Job
{
    public function __construct(private readonly int $roleId) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $role = Role::with('abilities')->findOrFail($this->roleId);
            $role->abilities()->detach();
            $role->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
