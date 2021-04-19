<?php namespace PlanetaDelEste\ApiShopaholic\Classes\Resource\Status;

use PlanetaDelEste\ApiToolbox\Classes\Resource\Base as BaseResource;
use PlanetaDelEste\ApiToolbox\Plugin;

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
    protected function getEvent(): ?string
    {
        return Plugin::EVENT_ITEMRESOURCE_DATA;
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        /** @var \Lovata\OrdersShopaholic\Models\Status $obModel */
        $obModel = $this->getObject();
        return [
            'color'         => $obModel ? $obModel->color : null,
            'name'          => trans($this->name),
            'name_for_user' => trans($this->name_for_user)
        ];
    }

    public function getDataKeys(): array
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
