<?php

namespace PlanetaDelEste\ApiShopaholic\Classes\Store\LoggedUser;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;
use PlanetaDelEste\ApiShopaholic\Models\LoggedUser;

class ListByLoggedStore extends AbstractStoreWithoutParam
{

    /**
     * @inheritDoc
     */
    protected function getIDListFromDB(): array
    {
        $iLifeTime = config('session.lifetime');
        $obTime = now()->subMinutes($iLifeTime);

        return LoggedUser::whereDate('last_activity_at', '>=', $obTime)->lists('id');
    }
}
