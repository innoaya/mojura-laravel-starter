<?php

namespace App\Modules\CoreModule\Jobs\User;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InnoAya\Mojura\Core\Job;

class UpdateUserJob extends Job
{
    public function __construct(private array $payload, private readonly int $userId) {}

    /**
     * Execute the job.
     *
     * @return User
     */
    public function handle()
    {
        $updatePayload = $this->payload;
        unset($updatePayload['avatar'], $updatePayload['avatar_updated']);

        $user = User::findOrFail($this->userId);
        $avatarUpdated = isset($this->payload['avatar_updated']) ? filter_var($this->payload['avatar_updated'], FILTER_VALIDATE_BOOLEAN) : false;

        if ($avatarUpdated) {
            if ($user->getAttributes()['avatar']) {
                // deleting old avatar file
                $oldFile = $user->getAttributes()['avatar'];
                Storage::exists($oldFile) ? Storage::delete($oldFile) : null;
            }
            if ($this->payload['avatar'] && $this->payload['avatar'] instanceof UploadedFile) {
                $file = $this->payload['avatar'];
                $filename = 'avatars/'.$user->username.time().'.'.$file->extension();
                Storage::putFileAs('', $file, $filename);
                $updatePayload['avatar'] = $filename;
            }
        }

        $user->update($updatePayload);

        return $user;
    }
}
