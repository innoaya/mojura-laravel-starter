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

        // Ensure JWT directory exists
        if (!Storage::drive('local')->exists('jwt')) {
            Storage::drive('local')->makeDirectory('jwt');
            $this->info('JWT directory created successfully.');
        }

        $privateKey = Storage::drive('local')->path('jwt/private.pem');
        $command = "openssl genrsa -passout pass:{$passphrase} -out {$privateKey}";
        exec($command);

        $publicKey = Storage::drive('local')->path('jwt/public.pem');
        $command = "openssl rsa -in {$privateKey} -passin pass:{$passphrase} -pubout -out {$publicKey}";
        exec($command);

        $this->info('Public and private keys have been generated successfully.');
    }
}
// This command generates a public/private key pair for JWT authentication.
// The private key is used to sign the JWT, and the public key is used to verify the signature.
// The keys are stored in the local storage under the 'jwt' directory.
// The command prompts the user for a passphrase to secure the private key.
// The passphrase is used to encrypt the private key.
// The command uses OpenSSL to generate the keys.
// The generated keys are in PEM format.
// The command checks if the 'jwt' directory exists in the local storage.
// If it does not exist, it creates the directory.
// The command uses the 'exec' function to run OpenSSL commands.
// The command uses the 'Storage' facade to interact with the local storage.
// The command uses the 'secret' method to prompt the user for a passphrase.
// The command uses the 'info' method to display messages to the user.
// The command uses the 'error' method to display error messages to the user.
// The command uses the 'handle' method to execute the command logic.
// The command uses the 'signature' property to define the command name and options.
// The command uses the 'description' property to define the command description.
// The command uses the 'protected' visibility modifier for the properties and methods.
// The command uses the 'public' visibility modifier for the 'handle' method.
// The command uses the 'private' visibility modifier for the 'privateKey' and 'publicKey' variables.
// The command uses the 'local' disk for storage.
// The command uses the 'drive' method to specify the storage disk.
// The command uses the 'path' method to get the full path of the storage file.
// The command uses the 'exists' method to check if a file exists in the storage.
// The command uses the 'makeDirectory' method to create a directory in the storage.
// The command uses the 'put' method to write data to a file in the storage.
