<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\RoleAbility.
 *
 * @property int $id
 * @property int $role_id
 * @property int $ability_id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility whereAbilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleAbility whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class RoleAbility extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'ability_id',
    ];
}
