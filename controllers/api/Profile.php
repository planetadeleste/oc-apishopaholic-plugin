<?php namespace PlanetaDelEste\ApiShopaholic\Controllers\Api;

use Kharanenka\Helper\Result;
use Lovata\Buddies\Models\User;
use PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource as ItemResourceUser;
use PlanetaDelEste\ApiToolbox\Classes\Api\Base;

/**
 * Class Profile
 *
 * @package PlanetaDelEste\ApiShopaholic\Controllers\Api
 *
 * @property User $obModel
 */
class Profile extends Base
{
    protected $arFileList = ['attachOne' => 'avatar'];

    public function getModelClass()
    {
        return User::class;
    }

    /**
     * @return \PlanetaDelEste\ApiShopaholic\Classes\Resource\User\ItemResource
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function index()
    {
        return ItemResourceUser::make($this->currentUser());
    }

    /**
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function avatar()
    {
        $this->currentUser();
        $sPath = $this->user->avatar ? $this->user->avatar->path : null;

        return Result::setData(['avatar' => $sPath])->get();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function addAddress()
    {
        if (!$this->hasPlugin('Lovata.OrdersShopaholic')) {
            return Result::setFalse()->setMessage('Plugin Lovata.OrdersShopaholic not installed')->get();
        }

        return $this->component(Lovata\OrdersShopaholic\Components\UserAddress::class)->onAdd();
    }

    /**
     * @return array
     * @throws \SystemException
     */
    public function updateAddress()
    {
        if (!$this->hasPlugin('Lovata.OrdersShopaholic')) {
            return Result::setFalse()->setMessage('Plugin Lovata.OrdersShopaholic not installed')->get();
        }
        return $this->component(Lovata\OrdersShopaholic\Components\UserAddress::class)->onUpdate();
    }

    /**
     * @return array
     * @throws \SystemException
     * @throws \Exception
     */
    public function removeAddress()
    {
        if (!$this->hasPlugin('Lovata.OrdersShopaholic')) {
            return Result::setFalse()->setMessage('Plugin Lovata.OrdersShopaholic not installed')->get();
        }
        return $this->component(Lovata\OrdersShopaholic\Components\UserAddress::class)->onRemove();
    }

    /**
     * @return mixed
     */
    protected function save()
    {
        $this->obModel->rules['password'] = 'required:create|between:8,255|confirmed';
        $this->obModel->rules['password_confirmation'] = 'required_with:password|between:8,255';

        if ($sAvatar = array_get($this->data, 'avatar')) {
            if (is_string($sAvatar)) {
                array_forget($this->data, 'avatar');
            }
        }

        $this->obModel->fill($this->data);
        $this->attachFiles();
        return $this->obModel->save();
    }
}
