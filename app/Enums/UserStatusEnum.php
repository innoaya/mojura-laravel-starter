<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case PENDING = 'Pending';
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case LOCKED = 'Locked';
}
