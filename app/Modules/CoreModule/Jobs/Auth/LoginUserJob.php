<?php

namespace App\Modules\CoreModule\Jobs\Auth;

use App\Enums\UserStatusEnum;
use App\Exceptions\UnauthorizedException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use InnoAya\Mojura\Core\Job;

class LoginUserJob extends Job
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
        try {
            $user = User::with('role.abilities')
                ->where('status', UserStatusEnum::ACTIVE->value)
                ->where(function ($query) {
                    $query->where('username', $this->payload['identifier'])
                        ->orwhere('email', $this->payload['identifier'])
                        ->orWhere('mobile_number', $this->payload['identifier']);
                })
                ->firstOrFail();
        } catch (ModelNotFoundException $_) {
            throw new UnauthorizedException('Wrong Credentials');
        }

        // Check if the user exists and the password is correct
        if (! $user || ! Hash::check($this->payload['password'], $user->password)) {
            throw new UnauthorizedException('Wrong Credentials');
        }

        // Generate the JWT token
        $accessToken = $user->createToken('authToken');

        return [
            'access_token' => $accessToken,
            'token_expires_in' => config('jwt.token_expiry'),
            'user_data' => $user,
        ];

    }
}
