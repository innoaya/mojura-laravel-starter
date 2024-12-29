<?php

namespace App\Modules\CoreModule\Jobs\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use InnoAya\Mojura\Core\Job;

class DeleteUserJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private readonly int $userId) {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {

            $user = User::findOrFail($this->userId);
            if ($user->avatar) {
                $file = 'public/'.$user->getAttributes()['avatar'];
                Storage::exists($file) ? Storage::delete($file) : null;
            }

            $user->destroyAllTokens();

            $user->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('Error deleting user: '.$e->getMessage());
        }
    }
}
