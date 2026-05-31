<?php

namespace PlanetaDelEste\ApiShopaholic\Models;

use Lovata\Buddies\Models\User;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class ApiUser extends User implements JWTSubject
{
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
