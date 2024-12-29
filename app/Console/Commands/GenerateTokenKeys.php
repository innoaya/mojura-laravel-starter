<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateTokenKeys extends Command
{
    protected $signature = 'jwt:keys';

    protected $description = 'Command to generate public and private keys for JWT.';

    public function handle(): void
    {
        $passphrase = $this->secret('Enter the passphrase for the private key');
        $passphraseConfirm = $this->secret('Confirm the passphrase for the private key');
        if ($passphrase !== $passphraseConfirm) {
            $this->error('The passphrases do not match.');

            return;
        }

        $privateKey = Storage::disk('local')->path('jwt/private.pem');
        $command = "openssl genrsa -passout pass:{$passphrase} -out {$privateKey}";
        exec($command);

        $publicKey = Storage::disk('local')->path('jwt/public.pem');
        $command = "openssl rsa -in {$privateKey} -passin pass:{$passphrase} -pubout -out {$publicKey}";
        exec($command);

        $this->info('Public and private keys have been generated successfully.');
    }
}
