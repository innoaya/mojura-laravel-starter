<?php

namespace App\Traits;

use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait JWTAuthTrait
{
    public function createToken(string $action = 'authToken'): string
    {
        if (empty($this->id)) {
            return '';
        }

        $config = JwtHelper::getJwtConfiguration();
        $date = new \DateTimeImmutable;
        $uniqueID = uniqid();

        // Get the token expiry from the .env file
        $expirySeconds = config('jwt.token_expiry'); // Default to 1 week if not set
        $expiration = $date->modify("+{$expirySeconds} seconds");

        $token = $config->builder()
            ->issuedBy(config('app.url'))
            ->permittedFor(config('app.url'))
            ->identifiedBy($uniqueID)
            ->relatedTo($this->id)
            ->issuedAt($date)
            ->canOnlyBeUsedAfter($date)
            ->expiresAt($expiration)
            ->getToken($config->signer(), $config->signingKey());

        // Retrieve client information and IP address
        $clientInfo = Request::header('User-Agent');
        $origin = Request::header('Origin');
        $ipAddress = Request::ip();

        DB::table('jwt_tokens')->insert([
            'user_id' => $this->id,
            'unique_id' => $uniqueID,
            'description' => $action.' '.$this->email,
            'client_info' => $clientInfo,
            'ip_address' => $ipAddress,
            'origin' => $origin,
            'abilities' => null,
            'expires_at' => $expiration,
            'last_used_at' => null,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // $this->token = $token->toString();
        return $token->toString();
    }

    public function destroyToken(string $tokenString): void
    {
        if (empty($tokenString)) {
            throw new \Exception('Token string is empty');
        }

        $config = JwtHelper::getJwtConfiguration();
        $token = $config->parser()->parse($tokenString);
        if (! method_exists($token, 'claims')) {
            throw new \Exception('Invalid Token');
        }

        $userID = $token->claims()->get('sub');
        $uniqueID = $token->claims()->get('jti');
        if (! $userID || ! $uniqueID || $this->id != $userID) {
            throw new \Exception('Invalid token');
        }

        if (! DB::table('jwt_tokens')->where([
            'unique_id' => $uniqueID,
            'user_id' => $this->id,
        ])->delete()) {
            throw new \Exception('Invalid token');
        }
    }

    public function destroyAllTokens(): void
    {
        DB::table('jwt_tokens')->where('user_id', $this->id)->delete();
    }
}
