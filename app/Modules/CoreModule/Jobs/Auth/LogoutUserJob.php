<?php

namespace App\Modules\CoreModule\Jobs\Auth;

use Illuminate\Support\Facades\Auth;
use InnoAya\Mojura\Core\Job;

class LogoutUserJob extends Job
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
        if ($this->payload['logOutAllSessions']) {
            Auth::user()->destroyAllTokens();
        } else {
            Auth::user()->destroyToken($this->payload['accessToken']);
        }
    }
}
