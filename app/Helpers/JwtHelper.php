<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;

class JwtHelper
{
    public static function getJwtConfiguration(): Configuration
    {
        $privateKeyPath = Storage::drive('local')->path('jwt/private.pem');
        if (empty($privateKeyPath) || !file_exists($privateKeyPath)) {
            throw new \InvalidArgumentException('Private key file does not exist or path is empty.');
        }

        $publicKeyPath = Storage::drive('local')->path('jwt/public.pem');
        if (empty($publicKeyPath) || !file_exists($publicKeyPath)) {
            throw new \InvalidArgumentException('Public key file does not exist or path is empty.');
        }

        $config = Configuration::forAsymmetricSigner(
            new Sha256,
            InMemory::file($privateKeyPath),
            InMemory::file($publicKeyPath)
        );

        // Add standard validation constraints
        $config->setValidationConstraints(
            new \Lcobucci\JWT\Validation\Constraint\SignedWith($config->signer(), $config->verificationKey()),
            new \Lcobucci\JWT\Validation\Constraint\IssuedBy(config('app.url')),
            new \Lcobucci\JWT\Validation\Constraint\PermittedFor(config('app.url')),
            new \Lcobucci\JWT\Validation\Constraint\StrictValidAt(new \Lcobucci\Clock\SystemClock(new \DateTimeZone(config('app.timezone'))))
        );

        return $config;
    }
}
