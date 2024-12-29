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
        $privateKeyPath = Storage::disk('local')->path('jwt/private.pem');
        if (empty($privateKeyPath)) {
            throw new \InvalidArgumentException('Private key path cannot be empty.');
        }

        $publicKeyPath = Storage::disk('local')->path('jwt/public.pem');
        if (empty($publicKeyPath)) {
            throw new \InvalidArgumentException('Public key path cannot be empty.');
        }

        return Configuration::forAsymmetricSigner(
            new Sha256,
            InMemory::file($privateKeyPath),
            InMemory::file($publicKeyPath)
        );
    }
}
