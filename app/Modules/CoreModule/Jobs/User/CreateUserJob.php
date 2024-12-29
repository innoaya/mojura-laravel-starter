<?php

namespace App\Modules\CoreModule\Jobs\User;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InnoAya\Mojura\Core\Job;

class CreateUserJob extends Job
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
        $createPayload = $this->payload;
        unset($createPayload['avatar']);
        if (isset($this->payload['avatar']) && $this->payload['avatar'] instanceof UploadedFile) {
            $file = $this->payload['avatar'];
            $filename = 'avatars/'.$this->payload['username'].time().'.'.$file->extension();
            Storage::putFileAs('', $file, $filename);
            $createPayload['avatar'] = $filename;
        }

        return User::create($createPayload);
    }
}
