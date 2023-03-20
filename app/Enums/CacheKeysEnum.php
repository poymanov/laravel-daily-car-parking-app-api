<?php

namespace App\Enums;

enum CacheKeysEnum: string
{
    case USER_ALL_VEHICLES = 'user-all-vehicles-';

    case VEHICLE = 'vehicle-';

    case ZONES = 'zones';
}
