<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Status;

use PlanetaDelEste\ApiShopaholic\Classes\Resource\Base\BaseResource;

/**
 * Class ItemResource
 *
 * @mixin \Lovata\OrdersShopaholic\Classes\Item\StatusItem
 * @package PlanetaDelEste\ApiShopaholic\Classes\Resource\Status
 */
class ItemResource extends BaseResource
{

    /**
     * @inheritDoc
     */
    protected function getEvent()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        /** @var \Lovata\OrdersShopaholic\Models\Status $obModel */
        $obModel = $this->getObject();
        return [
            'color' => $obModel ? $obModel->color : null
        ];
    }

    public function getDataKeys()
    {
        return [
            'id',
            'name',
            'name_for_user',
            'code',
            'preview_text',
            'is_user_show',
            'user_status_id',
            'color',
        ];
    }
}
