<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command will be scheduled to remove expired tokens.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get the current date and time
        $date = new \DateTimeImmutable;

        // Remove expired tokens
        DB::table('jwt_tokens')->where('expires_at', '<', $date)->delete();
    }
}
