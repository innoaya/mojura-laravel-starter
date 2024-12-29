<?php

namespace App\Models;

use App\Traits\BasicAudit;
use App\Traits\JWTAuthTrait;
use App\Traits\SnowflakeID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use BasicAudit, JWTAuthTrait, Notifiable, SnowflakeID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'role_id',
        'email',
        'full_name',
        'country_code',
        'mobile_number',
        'avatar',
        'status',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's avatar URL.
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? (
                Storage::exists($value)
                    ? Storage::url($value)
                    : null
            ) : null
        );
    }

    /**
     * Get the user's role name.
     */
    protected function roleName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->role->name
        );
    }
}
